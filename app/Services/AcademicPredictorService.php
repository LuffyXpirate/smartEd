<!-- <?php 
namespace App\Services;
use Illuminate\Support\Collection;
class AcademicPredictorService
{
    public function predictPerformance(array $yearlyData)
    {
        $years = collect($yearlyData)->pluck('year')->map(function($year) {
            return (float)$year;
        })->toArray();
        
        $scores = collect($yearlyData)->pluck('overall_percentage')->toArray();
        
        // Handle insufficient data
        if(count($years) < 2) {
            return [
                'error' => 'Not enough data for prediction'
            ];
        }

        // Calculate the slope and intercept for linear regression
        $n = count($years);
        $meanX = array_sum($years) / $n;
        $meanY = array_sum($scores) / $n;
        
        $numerator = 0;
        $denominator = 0;
        
        foreach($years as $index => $x) {
            $y = $scores[$index];
            $numerator += ($x - $meanX) * ($y - $meanY);
            $denominator += pow($x - $meanX, 2);
        }
        
        $slope = $numerator / $denominator;
        $intercept = $meanY - ($slope * $meanX);
        
        // Predict the next year's performance
        $predictedYear = max($years) + 1;
        $prediction = $intercept + ($slope * $predictedYear);
        
        return [
            'year' => $predictedYear,
            'percentage' => max(0, min(100, $prediction)),
            'confidence' => $this->calculateConfidence($years, $scores, $slope)
        ];
    }

    private function calculateConfidence($years, $scores, $slope)
    {
        // Implement confidence calculation logic
        $meanX = array_sum($years) / count($years);
        $meanY = array_sum($scores) / count($scores);
        
        $numerator = 0;
        $denominator = 0;
        
        foreach($years as $index => $x) {
            $y = $scores[$index];
            $numerator += ($x - $meanX) * ($y - $meanY);
            $denominator += pow($x - $meanX, 2);
        }
        
        $r = $numerator / sqrt($denominator * array_sum(array_map(function($y) use ($meanY) {
            return pow($y - $meanY, 2);
        }, $scores)));
        
        return round(abs($r) * 100, 2);
    }
} 