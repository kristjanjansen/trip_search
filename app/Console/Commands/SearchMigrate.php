<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Content;
use App\Comment;

class SearchMigrate extends Command
{

    protected $signature = 'search:migrate';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $i = 0;

        DB::connection('mysql2')
            ->table('contents')
            ->where('type', 'forum')
            ->orderBy('created_at', 'desc')
            ->chunk(100, function ($contents) use (&$i) {
                if ($i++ > 5) return false;
                dump($i);
                foreach ($contents as $content) {
                    Content::create([
                        'id' => $content->id,
                        'title' => $content->title,
                        'body' => $content->body,
                        'created_at' => $content->created_at,
                        'updated_at' => $content->updated_at
                    ]);
                    $comments = DB::connection('mysql2')
                        ->table('comments')
                        ->where('content_id', $content->id)
                        ->get();
                    $comments->each(function ($comment) {
                        Comment::create([
                            'id' => $comment->id,
                            'content_id' => $comment->content_id,
                            'body' => $comment->body,
                            'created_at' => $comment->created_at,
                            'updated_at' => $comment->updated_at
                        ]);
                    });
                }
            });
    }
}
