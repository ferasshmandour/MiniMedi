@extends('layouts.app')

@section('title', trans('messages.my_profile'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">👤 {{ trans('messages.my_profile') }}</h1>
    </div>

    <!-- Profile Photo Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <x-card>
                @slot('title')
                    <i class="bi bi-camera me-2"></i>{{ trans('messages.profile_photo') }}
                @endslot

                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        @if ($user->profile_photo_url)
                            <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" class="rounded-circle img-thumbnail"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 150px; height: 150px; font-size: 3rem; margin: 0 auto;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <form action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data"
                            id="photoUploadForm">
                            @csrf
                            <div class="mb-3">
                                <label for="photo" class="form-label">{{ trans('messages.upload_new_photo') }}</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*"
                                    required>
                                <div class="form-text">{{ trans('messages.photo_requirements') }}</div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-2"></i>{{ trans('messages.upload') }}
                            </button>
                        </form>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <div class="row mb-4">
        <!-- User Information -->
        <div class="col-md-6">
            <x-card>
                @slot('title')
                    <i class="bi bi-person me-2"></i>{{ trans('messages.user_information') }}
                @endslot

                <x-input name="name" label="{{ trans('messages.name') }}" :value="$user->name" disabled />
                <x-input name="email" label="{{ trans('messages.email') }}" :value="$user->email" disabled />
                <x-input name="role" label="{{ trans('messages.role') }}" :value="ucfirst($user->role)" disabled />
                <x-input name="member_since" label="{{ trans('messages.member_since') }}" :value="$user->created_at->format('F d, Y')" disabled />
            </x-card>
        </div>

        <!-- Role-Specific Profile -->
        <div class="col-md-6">
            <x-card>
                @slot('title')
                    @if ($user->isDoctor())
                        <i class="bi bi-activity me-2"></i>{{ trans('messages.doctor_profile') }}
                    @elseif($user->isPatient())
                        <i class="bi bi-person me-2"></i>{{ trans('messages.patient_profile') }}
                    @else
                        <i class="bi bi-gear me-2"></i>{{ trans('messages.admin_profile') }}
                    @endif
                @endslot

                @if ($user->isDoctor() && $user->doctor)
                    <x-input name="specialization" label="{{ trans('messages.specialization') }}" :value="$user->doctor->specialization"
                        disabled />
                    <x-input name="license_number" label="{{ trans('messages.license_number') }}" :value="$user->doctor->license_number"
                        disabled />
                    <x-input name="department" label="{{ trans('messages.department') }}" :value="$user->doctor->department ?? trans('messages.not_specified')" disabled />
                    <x-input name="phone" label="{{ trans('messages.phone') }}" :value="$user->doctor->phone ?? trans('messages.not_provided')" disabled />
                @elseif($user->isPatient() && $user->patient)
                    <x-input name="phone" label="{{ trans('messages.phone') }}" :value="$user->patient->phone ?? trans('messages.not_provided')" disabled />
                    <x-input name="date_of_birth" label="{{ trans('messages.date_of_birth') }}" :value="$user->patient->date_of_birth
                        ? $user->patient->date_of_birth->format('F d, Y')
                        : trans('messages.not_provided')"
                        disabled />
                    <x-input name="blood_type" label="{{ trans('messages.blood_type') }}" :value="$user->patient->blood_type ?? trans('messages.not_provided')" disabled />
                    <div class="mb-3">
                        <label class="form-label">{{ trans('messages.address') }}</label>
                        <textarea class="form-control" disabled rows="2">{{ $user->patient->address ?? trans('messages.not_provided') }}</textarea>
                    </div>
                @else
                    <p class="text-muted">{{ trans('messages.admin_users_description') }}</p>
                @endif
            </x-card>
        </div>
    </div>

    <!-- Doctor Specific: Certifications -->
    @if ($user->isDoctor() && $user->doctor)
        <div class="row mb-4">
            <div class="col-md-12">
                <x-card>
                    @slot('title')
                        <i class="bi bi-award me-2"></i>{{ trans('messages.certifications') }}
                    @endslot

                    <!-- Upload Certification Form -->
                    <form action="{{ route('profile.certification.upload') }}" method="POST" enctype="multipart/form-data"
                        class="mb-4">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="certification"
                                    class="form-label">{{ trans('messages.upload_certification') }}</label>
                                <input type="file" class="form-control" id="certification" name="certification"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                            </div>
                            <div class="col-md-4">
                                <label for="cert_name" class="form-label">{{ trans('messages.document_name') }}</label>
                                <input type="text" class="form-control" id="cert_name" name="name"
                                    placeholder="{{ trans('messages.optional') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload me-2"></i>{{ trans('messages.upload') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Certifications List -->
                    @if ($user->doctor->certifications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.name') }}</th>
                                        <th>{{ trans('messages.file_name') }}</th>
                                        <th>{{ trans('messages.size') }}</th>
                                        <th>{{ trans('messages.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->doctor->certifications as $cert)
                                        <tr>
                                            <td>{{ $cert->name }}</td>
                                            <td>{{ $cert->file_name }}</td>
                                            <td>{{ number_format($cert->size / 1024, 2) }} KB</td>
                                            <td>
                                                <a href="{{ $cert->getUrl() }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-download me-1"></i>{{ trans('messages.download') }}
                                                </a>
                                                <form action="{{ route('profile.certification.delete', $cert->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('{{ trans('messages.confirm_delete') }}')">
                                                        <i class="bi bi-trash me-1"></i>{{ trans('messages.delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-award"></i>
                            <p>{{ trans('messages.no_certifications') }}</p>
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    @endif

    <!-- Patient Specific: Medical Records -->
    @if ($user->isPatient() && $user->patient)
        <div class="row mb-4">
            <div class="col-md-12">
                <x-card>
                    @slot('title')
                        <i class="bi bi-file-medical me-2"></i>{{ trans('messages.medical_records') }}
                    @endslot

                    <!-- Upload Medical Record Form -->
                    <form action="{{ route('profile.medical-record.upload') }}" method="POST"
                        enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="record"
                                    class="form-label">{{ trans('messages.upload_medical_record') }}</label>
                                <input type="file" class="form-control" id="record" name="record"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                            </div>
                            <div class="col-md-4">
                                <label for="record_name" class="form-label">{{ trans('messages.document_name') }}</label>
                                <input type="text" class="form-control" id="record_name" name="name"
                                    placeholder="{{ trans('messages.optional') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload me-2"></i>{{ trans('messages.upload') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Medical Records List -->
                    @if ($user->patient->medical_records->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.name') }}</th>
                                        <th>{{ trans('messages.file_name') }}</th>
                                        <th>{{ trans('messages.size') }}</th>
                                        <th>{{ trans('messages.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->patient->medical_records as $record)
                                        <tr>
                                            <td>{{ $record->name }}</td>
                                            <td>{{ $record->file_name }}</td>
                                            <td>{{ number_format($record->size / 1024, 2) }} KB</td>
                                            <td>
                                                <a href="{{ $record->getUrl() }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-download me-1"></i>{{ trans('messages.download') }}
                                                </a>
                                                <form action="{{ route('profile.medical-record.delete', $record->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('{{ trans('messages.confirm_delete') }}')">
                                                        <i class="bi bi-trash me-1"></i>{{ trans('messages.delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-file-medical"></i>
                            <p>{{ trans('messages.no_medical_records') }}</p>
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    @endif

    <!-- User Documents (for all users) -->
    <div class="row mb-4">
        <div class="col-md-12">
            <x-card>
                @slot('title')
                    <i class="bi bi-folder me-2"></i>{{ trans('messages.documents') }}
                @endslot

                <!-- Upload Document Form -->
                <form action="{{ route('profile.document.upload') }}" method="POST" enctype="multipart/form-data"
                    class="mb-4">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label for="document" class="form-label">{{ trans('messages.upload_document') }}</label>
                            <input type="file" class="form-control" id="document" name="document"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                        </div>
                        <div class="col-md-4">
                            <label for="doc_name" class="form-label">{{ trans('messages.document_name') }}</label>
                            <input type="text" class="form-control" id="doc_name" name="name"
                                placeholder="{{ trans('messages.optional') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-2"></i>{{ trans('messages.upload') }}
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Documents List -->
                @if ($user->documents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ trans('messages.name') }}</th>
                                    <th>{{ trans('messages.file_name') }}</th>
                                    <th>{{ trans('messages.size') }}</th>
                                    <th>{{ trans('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->documents as $doc)
                                    <tr>
                                        <td>{{ $doc->name }}</td>
                                        <td>{{ $doc->file_name }}</td>
                                        <td>{{ number_format($doc->size / 1024, 2) }} KB</td>
                                        <td>
                                            <a href="{{ $doc->getUrl() }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download me-1"></i>{{ trans('messages.download') }}
                                            </a>
                                            <form action="{{ route('profile.document.delete', $doc->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('{{ trans('messages.confirm_delete') }}')">
                                                    <i class="bi bi-trash me-1"></i>{{ trans('messages.delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-folder"></i>
                        <p>{{ trans('messages.no_documents') }}</p>
                    </div>
                @endif
            </x-card>
        </div>
    </div>

    <!-- Medical Information (for patients) -->
    @if ($user->isPatient() && $user->patient)
        <x-card class="mb-4">
            @slot('title')
                <i class="bi bi-hospital me-2"></i>{{ trans('messages.medical_information') }}
            @endslot

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{ trans('messages.allergies') }}</label>
                        <textarea class="form-control" disabled rows="2">{{ $user->patient->allergies ?? trans('messages.none_known') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{ trans('messages.medical_history') }}</label>
                        <textarea class="form-control" disabled rows="2">{{ $user->patient->medical_history ?? trans('messages.no_medical_history') }}</textarea>
                    </div>
                </div>
            </div>
        </x-card>
    @endif

    <!-- Statistics -->
    <x-card>
        @slot('title')
            <i class="bi bi-bar-chart me-2"></i>{{ trans('messages.statistics') }}
        @endslot

        <div class="row">
            @if ($user->isAdmin())
                <div class="col-md-4">
                    <div class="stat-card text-center p-3 bg-primary text-white rounded">
                        <h3 class="mb-0">{{ \App\Models\User::count() }}</h3>
                        <p class="mb-0">{{ trans('messages.total_users') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card text-center p-3 bg-success text-white rounded">
                        <h3 class="mb-0">{{ \App\Models\Appointment::count() }}</h3>
                        <p class="mb-0">{{ trans('messages.total_appointments') }}</p>
                    </div>
                </div>
            @elseif($user->isDoctor())
                <div class="col-md-4">
                    <div class="stat-card text-center p-3 bg-primary text-white rounded">
                        <h3 class="mb-0">{{ $user->appointmentsAsDoctor()->count() }}</h3>
                        <p class="mb-0">{{ trans('messages.total_appointments') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card text-center p-3 bg-success text-white rounded">
                        <h3 class="mb-0">{{ $user->appointmentsAsDoctor()->where('status', 'completed')->count() }}</h3>
                        <p class="mb-0">{{ trans('messages.completed') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card text-center p-3 bg-info text-white rounded">
                        <h3 class="mb-0">{{ $user->medicalNotes()->count() }}</h3>
                        <p class="mb-0">{{ trans('messages.medical_notes') }}</p>
                    </div>
                </div>
            @else
                <div class="col-md-6">
                    <div class="stat-card text-center p-3 bg-primary text-white rounded">
                        <h3 class="mb-0">{{ $user->appointmentsAsPatient()->count() }}</h3>
                        <p class="mb-0">{{ trans('messages.total_appointments') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card text-center p-3 bg-success text-white rounded">
                        <h3 class="mb-0">{{ $user->appointmentsAsPatient()->where('status', 'completed')->count() }}
                        </h3>
                        <p class="mb-0">{{ trans('messages.completed') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </x-card>
@endsection
