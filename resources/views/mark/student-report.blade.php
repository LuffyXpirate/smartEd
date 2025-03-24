@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2>{{ $student->first_name }} {{ $student->last_name }}'s Academic Report</h2>
        </div>
        
        <!-- Yearly Performance Summary -->
        <div class="card-body">
            <h4 class="mb-4">Yearly Performance Overview</h4>
            <div class="row">
                @foreach($yearlyData as $year)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Academic Year {{ $year->year }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1">Overall Percentage: <strong>{{ number_format($year->overall_percentage, 2) }}%</strong></p>
                            <p class="mb-1">Total Exams: {{ $year->total_exams }}</p>
                            @if(!$loop->first)
                                @php $prevYear = $yearlyData[$loop->index - 1] @endphp
                                <p class="mb-0 text-{{ ($year->overall_percentage > $prevYear->overall_percentage) ? 'success' : 'danger' }}">
                                    Trend: {{ ($year->overall_percentage > $prevYear->overall_percentage) ? '↑ Improvement' : '↓ Decline' }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Subject-wise Analysis -->
            <h4 class="mt-5 mb-4">Subject-wise Performance</h4>
            <div class="row">
                @foreach($subjectPerformance as $subject)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $subject->subject->subject_name }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <p class="mb-1">Average: {{ number_format($subject->avg_score, 2) }}%</p>
                                    <p class="mb-1">Highest: {{ $subject->highest_score }}%</p>
                                    <p class="mb-0">Lowest: {{ $subject->lowest_score }}%</p>
                                </div>
                                <div class="col-8">
                                    @php
                                        $classAvg = $classAverages
                                            ->flatMap(function ($yearData) use ($subject) {
                                                return $yearData->where('subject_id', $subject->subject_id);
                                            })
                                            ->avg('class_avg');
                                    @endphp
                                    <div class="progress" style="height: 30px;">
                                        <div class="progress-bar bg-success" 
                                             style="width: {{ $subject->avg_score }}%">
                                            Student
                                        </div>
                                        <div class="progress-bar bg-info" 
                                             style="width: {{ max(0, $classAvg - $subject->avg_score) }}%">
                                            Class Avg
                                        </div>
                                    </div>
                                    <small class="text-muted mt-2 d-block">
                                        Class Average: {{ number_format($classAvg, 2) }}%
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Improvement Suggestions -->
            <div class="mt-5">
                <h4>Recommendations</h4>
                <div class="alert alert-warning">
                    <ul class="mb-0">
                        @foreach($subjectPerformance->sortBy('avg_score')->take(3) as $subject)
                            <li>Focus on improving {{ $subject->subject->subject_name }} (Current avg: {{ $subject->avg_score }}%)</li>
                        @endforeach
                        <li>Practice previous year question papers</li>
                        <li>Attend extra help sessions for weak subjects</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection