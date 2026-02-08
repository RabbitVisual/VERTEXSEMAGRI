<?php

namespace Modules\Blog\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\App\Models\BlogComment;
use Modules\Blog\App\Models\BlogPost;

class BlogCommentsAdminController extends Controller
{
    /**
     * Display comments list
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'post']);

        $query = BlogComment::with(['post', 'user', 'parent'])
            ->orderBy('created_at', 'desc');

        // Aplicar filtros
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('content', 'like', "%{$filters['search']}%")
                  ->orWhere('author_name', 'like', "%{$filters['search']}%")
                  ->orWhere('author_email', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['post'])) {
            $query->where('post_id', $filters['post']);
        }

        $comments = $query->paginate(20);

        $estatisticas = [
            'total_comments' => BlogComment::count(),
            'approved_comments' => BlogComment::approved()->count(),
            'pending_comments' => BlogComment::pending()->count(),
            'rejected_comments' => BlogComment::where('status', 'rejected')->count(),
        ];

        $posts = BlogPost::select('id', 'title')->orderBy('title')->get();

        return view('blog::admin.comments.index', compact('comments', 'filters', 'estatisticas', 'posts'));
    }

    /**
     * Display the specified comment.
     */
    public function show($id)
    {
        $comment = BlogComment::with(['post', 'user', 'parent', 'replies.user'])
            ->findOrFail($id);

        return view('blog::admin.comments.show', compact('comment'));
    }

    /**
     * Approve comment
     */
    public function approve($id)
    {
        $comment = BlogComment::findOrFail($id);

        $comment->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);

        return redirect()->back()
            ->with('success', 'Comentário aprovado com sucesso!');
    }

    /**
     * Reject comment
     */
    public function reject($id)
    {
        $comment = BlogComment::findOrFail($id);

        $comment->update([
            'status' => 'rejected',
            'approved_at' => null,
            'approved_by' => null
        ]);

        return redirect()->back()
            ->with('success', 'Comentário rejeitado com sucesso!');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.blog.comments.index')
            ->with('success', 'Comentário excluído com sucesso!');
    }

    /**
     * Bulk approve comments
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'comments' => 'required|array',
            'comments.*' => 'exists:blog_comments,id'
        ]);

        BlogComment::whereIn('id', $request->comments)
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);

        return redirect()->back()
            ->with('success', 'Comentários aprovados com sucesso!');
    }

    /**
     * Bulk reject comments
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'comments' => 'required|array',
            'comments.*' => 'exists:blog_comments,id'
        ]);

        BlogComment::whereIn('id', $request->comments)
            ->update([
                'status' => 'rejected',
                'approved_at' => null,
                'approved_by' => null
            ]);

        return redirect()->back()
            ->with('success', 'Comentários rejeitados com sucesso!');
    }

    /**
     * Bulk delete comments
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'comments' => 'required|array',
            'comments.*' => 'exists:blog_comments,id'
        ]);

        BlogComment::whereIn('id', $request->comments)->delete();

        return redirect()->back()
            ->with('success', 'Comentários excluídos com sucesso!');
    }
}
