<?php

namespace App\Http\Traits;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\DocumentResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Document;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Notificatable
{

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notificatable');
    }

    public function notificaionsStore(Category|Document|Comment $model, string $message)
    {
        $notification = $model->notifications()->create([
            'message'  => $message
        ]);

        return $notification;
    }

    public function getNotificationItemResource(string $notificatableType, int $notificatableId)
    {
        switch ($notificatableType) {
            case 'App\Models\Category':
                $category = Category::findOrFail($notificatableId);
                return ['item_type' => 'Category', new CategoryResource($category)];
                break;
            case 'App\Models\Document':
                $document = Document::findOrFail($notificatableId);
                return ['item_type' => 'Document', new DocumentResource($document)];
                break;
            case 'App\Models\Comment':
                $comment = Comment::findOrFail($notificatableId);
                return ['item_type' => 'Comment', new CommentResource($comment)];
                break;
            default:
                return 'Not Found!';
                break;
        }
    }

    public function sendNotification(Notification $notification)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $serverKey = 'AAAAP0GeWyY:APA91bHn-Vt2yZyv9oBDNE2zm85GFriGaxRsc40JXgelsL8S3JgEg1AHS1YDy7EUMHTAmyKbSei8j4CH708mDk7idTK5myq_8KOLnsjv5pfxw_WPxvgSVFgBSsdKLrNumFDzjTB9GCk-';

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "message"               => $notification->message,
                "notificatable_id"   => $notification->notificatable_id,
                "notificatable_type" => $notification->notificatable_type,
            ]
        ];

        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);
    }
}
