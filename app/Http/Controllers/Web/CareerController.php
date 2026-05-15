<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $vacancies = JobVacancy::active()->ordered()->get();

        return view('careers.index', [
            'vacancies' => $vacancies,
            'hasVacancies' => $vacancies->isNotEmpty(),
        ]);
    }

    public function show(JobVacancy $vacancy)
    {
        if (!$vacancy->is_active) {
            abort(404);
        }

        if ($vacancy->closes_at && $vacancy->closes_at->isPast()) {
            abort(404);
        }

        return view('careers.show', [
            'vacancy' => $vacancy,
        ]);
    }

    public function apply(Request $request, JobVacancy $vacancy)
    {
        if (!$vacancy->is_active) {
            abort(404);
        }

        $data = $this->validateApplication($request);

        $data['job_vacancy_id'] = $vacancy->id;
        $data['resume_path'] = $this->storeResume($request);
        $data['status'] = 'nuevo';

        JobApplication::create($data);

        return redirect()
            ->route('careers.show', $vacancy)
            ->with('success', '¡Gracias por postularte! Revisaremos tu información y te contactaremos pronto.');
    }

    public function storeOpen(Request $request)
    {
        $data = $this->validateApplication($request);

        $data['job_vacancy_id'] = null;
        $data['resume_path'] = $this->storeResume($request);
        $data['status'] = 'nuevo';

        JobApplication::create($data);

        return redirect()
            ->route('careers.index')
            ->with('success', '¡Gracias por dejarnos tus datos! Te contactaremos cuando tengamos una vacante que se ajuste a tu perfil.');
    }

    protected function validateApplication(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:255'],
            'position_interest' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:3000'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);
    }

    protected function storeResume(Request $request): ?string
    {
        if (!$request->hasFile('resume')) {
            return null;
        }
        return $request->file('resume')->store('resumes', 'public');
    }
}
