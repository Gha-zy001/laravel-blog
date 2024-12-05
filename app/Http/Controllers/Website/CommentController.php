<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  public function showPost($postId)
  {
    $post = Post::with('comments.user')->findOrFail($postId);
    // $categoryName = $post->category->name ?? 'Uncategorized';
    $comments = $post->comments;

    return view('posts.blog-post', compact('post', 'comments'));
  }

  public function store(Request $request, Post $post)
  {
    // Validate the incoming request
    $request->validate([
      'content' => 'required|string|max:255',
    ]);

    // Create a new comment
    $comment = new Comment();
    $comment->content = $request->input('content');
    $comment->user_id = auth()->id(); // Link the comment to the authenticated user
    $comment->post_id = $post->id;    // Link the comment to the specific post
    $comment->save();

    // Redirect back to the post page after storing the comment
    return back()->with('success', 'Comment added successfully!');
  }
}
