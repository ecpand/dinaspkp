<?php

namespace App\Http\Controllers;

use App\Models\ServiceReview;
use Illuminate\Http\Request;

class ServiceReviewController extends Controller
{
    public function index(Request $request)
    {
        $distribution = ServiceReview::selectRaw('rating, count(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');
        $total = $distribution->sum();

        $reviews = ServiceReview::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = trim($request->string('q')->toString());
                $query->where(function ($reviewQuery) use ($keyword) {
                    $reviewQuery->where('name', 'like', "%{$keyword}%")
                        ->orWhere('feedback', 'like', "%{$keyword}%");
                });
            })
            ->when($request->filled('rating'), fn ($query) => $query->where('rating', $request->integer('rating')))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('created_at', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('created_at', '<=', $request->date('date_to')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('console.reviews', [
            'reviews' => $reviews,
            'total' => $total,
            'filteredTotal' => $reviews->total(),
            'average' => $total ? round(ServiceReview::avg('rating'), 1) : 0,
            'distribution' => $distribution,
        ]);
    }
    public function destroy(ServiceReview $review) { $review->delete(); return back()->with('success','Ulasan dihapus.'); }
}
