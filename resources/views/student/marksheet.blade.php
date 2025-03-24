@extends('Layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Academic Marksheet</h3>
            <h4 class="mb-0">{{ auth()->user()->name }}</h4>
            <p class="mb-0">Class: {{ $student->class }} | Roll No: {{ $student->roll_no }}</p>
        </div>

        <div class="card-body">
            @foreach($examTypes as $key => $type)
                @if(isset($marks[$key]))
                <div class="mb-5">
                    <h4 class="border-bottom pb-2">{{ $type }} Results</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Marks Obtained</th>
                                    <th>Total Marks</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; $maxTotal = 0; @endphp
                                @foreach($marks[$key] as $mark)
                                <tr>
                                    <td>{{ $mark->subject->subject_name }}</td>
                                    <td>{{ $mark->marks_obtained }}</td>
                                    <td>{{ $mark->total_marks }}</td>
                                    <td>{{ number_format(($mark->marks_obtained/$mark->total_marks)*100, 2) }}%</td>
                                    <td>{{ calculateGrade($mark->marks_obtained, $mark->total_marks) }}</td>
                                </tr>
                                @php 
                                    $total += $mark->marks_obtained;
                                    $maxTotal += $mark->total_marks;
                                @endphp
                                @endforeach
                                <tr class="bg-light">
                                    <th colspan="2">Total</th>
                                    <th>{{ $total }}/{{ $maxTotal }}</th>
                                    <th colspan="2">{{ number_format(($total/$maxTotal)*100, 2) }}%</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection

@php
function calculateGrade($obtained, $total) {
    $percentage = ($obtained/$total)*100;
    
    if($percentage >= 90) return 'A+';
    if($percentage >= 80) return 'A';
    if($percentage >= 70) return 'B+';
    if($percentage >= 60) return 'B';
    if($percentage >= 50) return 'C+';
    if($percentage >= 40) return 'C';
    return 'F';
}
@endphp