@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-4">Student Progress Report: {{ $student->full_name }}</h2>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Roll No:</strong> {{ $student->roll_no }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Current Class:</strong> {{ $student->class->class_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Academic Year:</strong> {{ $student->class->academic_year ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Performance Chart</h4>
                </div>
                <div class="card-body">
                    <canvas id="performanceChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Detailed Marks</h4>
                </div>
                <div class="card-body">
                    @foreach($groupedMarks as $examType => $subjects)
                    <div class="mb-4">
                        <h5>{{ $examType }}</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Marks Obtained</th>
                                        <th>Exam Date</th>
                                        <th>Class</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects->flatten() as $mark)
                                    <tr>
                                        <td>{{ $mark->subject->subject_name }}</td>
                                        <td>{{ $mark->marks_obtained }}</td>
                                        <td>{{ \Carbon\Carbon::parse($mark->exam_date)->format('d M Y') }}</td>
                                        <td> {{ $student->class->class_name ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const chartData = @json($chartData);
        
        const examTypes = ['First Term', 'Second Term', 'Third Term', 'Final'];
        const datasets = [];

        // Prepare datasets for each subject
        Object.entries(chartData).forEach(([subject, marks]) => {
            const data = examTypes.map(examType => marks[examType] || 0);
            
            datasets.push({
                label: subject,
                data: data,
                borderColor: getRandomColor(),
                fill: false,
                tension: 0.1
            });
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: examTypes,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Marks Obtained'
                        }
                    }
                }
            }
        });

        function getRandomColor() {
            return '#' + Math.floor(Math.random()*16777215).toString(16);
        }
    });
</script>
@endsection