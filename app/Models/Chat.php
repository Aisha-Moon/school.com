<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table='chats';
    static public function getChat($receiver_id, $sender_id)
    {
        $query= self::select('chats.*')
            ->where(function ($q) use ($receiver_id, $sender_id) {
                $q->where(function ($q) use ($receiver_id, $sender_id) {
                    $q->where('receiver_id', $sender_id)
                        ->where('sender_id', $receiver_id)
                        ->where('status', '>', '-1');
                })->orWhere(function ($q) use ($receiver_id, $sender_id) {
                    $q->where('receiver_id', $receiver_id)
                        ->where('sender_id', $sender_id);
                });
            })
            ->where('message', '!=', '')
            ->orderBy('id', 'asc')
            ->get();
            return $query;
    }


    public function getSender(){
       return $this->belongsTo(User::class,'sender_id');
    }
    public function getReceiver(){
        return  $this->belongsTo(User::class,'receiver_id');
    }
}
