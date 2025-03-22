<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->integer('total_marks');
            $table->string('exam_type');
            $table->date('exam_date');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('marks');
    }
};
