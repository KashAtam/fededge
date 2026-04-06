<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->enum('document_type', [
                'drivers_license',
                'vehicle_license',
                'insurance',
                'roadworthiness_certificate',
                'registration_certificate',
                'inspection_report'
            ]);
            $table->string('file_path');
            $table->string('original_filename');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('pending')->index();
            $table->text('admin_feedback')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index('vehicle_id');
            $table->index('document_type');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
