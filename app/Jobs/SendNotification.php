<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $url;
    protected $title;
    protected $body;
    protected $user_id;

    /**
     * Create a new job instance.
     *
     * @param  mixed  $model
     * @param  string  $url
     * @param  string  $title
     * @param  string  $body
     * @param  int  $user_id
     * @return void
     */
    public function __construct($model, $url, $title, $body, $user_id)
    {
        $this->model = $model;
        $this->url = $url;
        $this->title = $title;
        $this->body = $body;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all kids associated with the model (if the model has kids)
        $kids = $this->model->kids ?? collect();

        // If the model is a type that has related kids, handle sending notifications to parents
        foreach ($kids as $kid) {
            if ($kid->parent_id) {
                $parent = User::find($kid->parent_id);
                if ($parent) {
                    send_notification($this->url, $this->model, $this->title, $this->body, $kid->parent->user_id, $parent->device_token);
                }
            }
        }

        // If model doesn't have kids, you can customize this to send a notification to other types of users (e.g., admin, owner)
        if (!$kids->count()) {
            $user = User::find($this->user_id);
            if ($user) {
                send_notification($this->url, $this->model, $this->title, $this->body, $this->user_id, $user->device_token);
            }
        }
    }
}
