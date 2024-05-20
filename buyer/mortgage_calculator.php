<?php
session_start();
require_once 'MortgageCalculatorController.php';

$calculatorManager = new MortgageCalculatorManager();

if (isset($_GET['calc'])) {
    $calc = floatval($_GET['calc']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calculate'])) {
    $loanAmount = isset($_POST['loan_amount']) ? floatval($_POST['loan_amount']) : 0;
    $interestRate = isset($_POST['interest_rate']) ? floatval($_POST['interest_rate']) : 0;
    $years = isset($_POST['years']) ? intval($_POST['years']) : 0;

    $loanTermMonths = $years * 12;

    if ($loanAmount > 0 && $interestRate > 0 && $loanTermMonths > 0) {
        // Create a new mortgage calculator instance
        $calculator = new MortgageCalculator($loanAmount, $interestRate, $loanTermMonths);
        // Add calculator to the manager with a unique property name
        $calculatorManager->addCalculator('Property', $calculator);
    }
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

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="loan_amount">Loan Amount:</label>
            <input type="number" id="loan_amount" name="loan_amount" step="0.01" value="<?php echo $calc; ?>"><br><br>
            <label for="interest_rate">Interest Rate (% per annum):</label>
            <input type="number" id="interest_rate" name="interest_rate" step="0.01" required><br><br>
            <label for="loan_term">Loan Term (years):</label>
            <select name="years" id="years" required>
                <option value="" selected disabled>Select Years</option>
                <?php for ($i = 35; $i >= 1; $i--): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?> Year<?php echo $i !== 1 ? 's' : ''; ?></option>
                <?php endfor; ?>
            </select><br><br>
            <button type="submit" name="calculate">Calculate</button>
        </form>

        <?php if (!empty($calculatorManager->getCalculator('Property'))): ?>
            <h3>Monthly Repayment Details</h3>
            <table>
                <tr>
                    <th>Loan Amount</th>
                    <th>Interest Rate</th>
                    <th>Loan Term</th>
                    <th>Monthly Repayment</th>
                    <th>Total Interest</th>
                </tr>
                <tr>
                    <td><?php echo formatCurrency($loanAmount); ?></td>
                    <td><?php echo $interestRate; ?>%</td>
                    <td><?php echo $years; ?> Year<?php echo $years !== 1 ? 's' : ''; ?></td>
                    <td><?php echo formatCurrency($calculatorManager->getCalculator('Property')->getMonthlyRepayment()); ?>
                    </td>
                    <td><?php echo formatCurrency($calculatorManager->getCalculator('Property')->getTotalInterest()); ?>
                    </td>
                </tr>
            </table>
        <?php endif; ?>

        <?php
        function formatCurrency($amount)
        {
            return '$' . number_format($amount, 2);
        }
        ?>
    </main>
</body>

</html>
