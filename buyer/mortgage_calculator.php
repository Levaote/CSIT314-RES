<?php
session_start();
require_once 'MortgageCalculatorController.php';
require_once '../dbconnect.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$buyerID = $_SESSION['user_id'];
$calculatorManager = new MortgageCalculatorManager($conn, $buyerID);

if (isset($_GET['calc'])) {
    $calc = floatval($_GET['calc']);
} else {
    $calc = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['calculate'])) {
        $loanAmount = isset($_POST['cloan_amount']) ? floatval($_POST['cloan_amount']) : 0;
        $interestRate = isset($_POST['cinterest_rate']) ? floatval($_POST['cinterest_rate']) : 0;
        $years = isset($_POST['cyears']) ? intval($_POST['cyears']) : 0;

        $loanTermMonths = $years * 12;

        if ($loanAmount > 0 && $interestRate > 0 && $loanTermMonths > 0) {
            // Create a new mortgage calculator instance
            $calculator = new MortgageCalculator($loanAmount, $interestRate, $loanTermMonths);
            // Add calculator to the manager with a unique property name
            $calculatorManager->addCalculator('New', $calculator);
        }
    } elseif (isset($_POST['save_calculation'])) {
        $loanAmount = ($_POST['loan_amount']);
        $interestRate = ($_POST['interest_rate']);
        $loanTermYears = ($_POST['loan_term_years']);
        $monthlyRepayment = ($_POST['monthly_repayment']);
        $totalInterest = ($_POST['total_interest']);

        $calculatorManager->saveCalculation($loanAmount, $interestRate, $loanTermYears, $monthlyRepayment, $totalInterest);
        header("Location: mortgage_calculator.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $calculationID = $_GET['delete'];
    $calculatorManager->deleteSavedCalculation($calculationID);
    header("Location: mortgage_calculator.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Calculator</title>
    <link rel="stylesheet" href="buyer.css">
</head>

<body>
    <header>
        <h1>Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Buyer'; ?>!
        </h1>
        <nav>
            <ul>
                <li><a href="buyer.php">Home</a></li>
                <li><a href="browse_properties.php">Browse Properties</a></li>
                <li><a href="mortgage_calculator.php">Mortgage Calculator</a></li>
                <li><a href="../review/agent_ratings.php">Agent Ratings & Reviews</a></li>
                <li><a href="accounts.php">Account</a></li>
                <li><a href="../LogoutController.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Mortgage Calculator</h2>

        <?php $calculatorManager->displayMortgageCalcForm($calc);

        if (!empty($calculatorManager->getCalculator('New'))){
            $calculatorManager->displayCalculationResult();}

        $calculatorManager->displaySavedCalculations(); ?>
    </main>
</body>

</html>