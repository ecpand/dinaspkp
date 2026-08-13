<?php

namespace App\Http\Controllers;

use App\Models\ProposalData;
use Illuminate\Http\Request;

class ProposalDataController extends Controller
{
    public function index(Request $request)
    {
        $query = ProposalData::query();
        $query->when($request->filled('cari'), fn ($items) => $items->where(fn ($search) => $search
            ->where('applicant_name', 'like', '%'.$request->string('cari').'%')
            ->orWhere('national_id', 'like', '%'.$request->string('cari').'%')
            ->orWhere('village_name', 'like', '%'.$request->string('cari').'%')));
        $query->when($request->filled('tahun'), fn ($items) => $items->where('proposal_year', $request->integer('tahun')));
        $query->when($request->filled('kabupaten'), fn ($items) => $items->where('regency_name', $request->string('kabupaten')));
        $query->when($request->filled('status'), fn ($items) => $items->where('status', $request->string('status')));
        $base = ProposalData::query();

        return view('console.proposal-data.index', [
            'proposals' => $query->latest()->paginate(10)->withQueryString(),
            'total' => $base->count(),
            'verified' => (clone $base)->where('status', 'verified')->count(),
            'years' => (clone $base)->distinct()->orderByDesc('proposal_year')->pluck('proposal_year'),
            'regencies' => (clone $base)->whereNotNull('regency_name')->distinct()->orderBy('regency_name')->pluck('regency_name'),
        ]);
    }

    public function store(Request $request)
    {
        ProposalData::create($this->data($request));
        return back()->with('success', 'Data usulan berhasil ditambahkan.');
    }

    public function update(Request $request, ProposalData $proposal)
    {
        $proposal->update($this->data($request, $proposal));
        return back()->with('success', 'Data usulan berhasil diperbarui.');
    }

    public function destroy(ProposalData $proposal)
    {
        $proposal->delete();
        return back()->with('success', 'Data usulan berhasil dihapus.');
    }

    private function data(Request $request, ?ProposalData $proposal = null): array
    {
        return $request->validate([
            'source_number' => ['nullable', 'integer', 'min:1'],
            'proposal_year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'proposal_number' => ['nullable', 'string', 'max:255', 'unique:proposal_data,proposal_number'.($proposal ? ','.$proposal->id : '')],
            'applicant_name' => ['required', 'string', 'max:255'],
            'national_id' => ['nullable', 'string', 'max:32'], 'family_card_number' => ['nullable', 'string', 'max:32'],
            'dtsen_backlog' => ['nullable', 'string', 'max:50'], 'dtsen_decile' => ['nullable', 'string', 'max:50'],
            'province_name' => ['nullable', 'string', 'max:255'], 'regency_name' => ['nullable', 'string', 'max:255'],
            'district_name' => ['nullable', 'string', 'max:255'], 'village_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'], 'applicant_phone' => ['nullable', 'string', 'max:40'],
            'land_ownership_type' => ['nullable', 'string', 'max:255'], 'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'], 'proposal_category' => ['nullable', 'string', 'max:255'],
            'proposal_type' => ['nullable', 'string', 'max:255'], 'description' => ['nullable', 'string'],
            'beneficiary_count' => ['nullable', 'integer', 'min:0'], 'estimated_budget' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:submitted,verified,approved,rejected'], 'verification_notes' => ['nullable', 'string'],
            'ktp_file_url' => ['nullable', 'url', 'max:2048'], 'kk_file_url' => ['nullable', 'url', 'max:2048'],
            'certificate_file_url' => ['nullable', 'url', 'max:2048'], 'photo_front_url' => ['nullable', 'url', 'max:2048'],
            'photo_back_url' => ['nullable', 'url', 'max:2048'], 'photo_left_url' => ['nullable', 'url', 'max:2048'],
            'photo_right_url' => ['nullable', 'url', 'max:2048'], 'photo_inside_url' => ['nullable', 'url', 'max:2048'],
        ]);
    }
}
