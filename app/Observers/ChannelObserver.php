<?php

namespace App\Observers;

use App\Models\Channel;
use App\Models\Conversation;

class ChannelObserver
{
    /**
     * Handle the channel "creating" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function creating(Channel $channel)
    {
        if (! $channel->conversation_id) {
            $channel->conversation_id = Conversation::create()->id;
        }
    }
}
