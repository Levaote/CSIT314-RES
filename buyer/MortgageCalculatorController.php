<?php
class MortgageCalculator
{
    private $loanAmount;
    private $interestRate;
    private $loanTermMonths;
    private $monthlyRepayment;
    private $totalInterest;

    public function __construct($loanAmount = 0, $interestRate = 0, $loanTermMonths = 0)
    {
        $this->loanAmount = $loanAmount;
        $this->interestRate = $interestRate;
        $this->loanTermMonths = $loanTermMonths;
        $this->calculateMonthlyRepayment();
        $this->calculateTotalInterest();
    }

    public function setLoanAmount($loanAmount)
    {
        $this->loanAmount = $loanAmount;
        $this->calculateMonthlyRepayment();
        $this->calculateTotalInterest();
    }

    public function setInterestRate($interestRate)
    {
        $this->interestRate = $interestRate;
        $this->calculateMonthlyRepayment();
        $this->calculateTotalInterest();
    }

    public function setLoanTermMonths($loanTermMonths)
    {
        $this->loanTermMonths = $loanTermMonths;
        $this->calculateMonthlyRepayment();
        $this->calculateTotalInterest();
    }

    public function getMonthlyRepayment()
    {
        return $this->monthlyRepayment;
    }

    public function getTotalInterest()
    {
        return $this->totalInterest;
    }

    public function getLoanAmount()
    {
        return $this->loanAmount;
    }

    public function getInterestRate()
    {
        return $this->interestRate;
    }

    public function getLoanTermMonths()
    {
        return $this->loanTermMonths;
    }

    private function calculateMonthlyRepayment()
    {
        $monthlyInterestRate = ($this->interestRate / 100) / 12;
        $numerator = $this->loanAmount * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $this->loanTermMonths);
        $denominator = pow(1 + $monthlyInterestRate, $this->loanTermMonths) - 1;
        $this->monthlyRepayment = $numerator / $denominator;
    }

    private function calculateTotalInterest()
    {
        $this->totalInterest = $this->monthlyRepayment * $this->loanTermMonths - $this->loanAmount;
    }
}

class MortgageCalculatorManager
{
    protected $conn;
    protected $buyerID;
    private $calculators = [];

    public function __construct($conn, $buyerID)
    {
        $this->conn = $conn;
        $this->buyerID = $buyerID;
    }

    public function addCalculator($propertyName, MortgageCalculator $calculator)
    {
        $this->calculators[$propertyName] = $calculator;
    }

    public function getCalculator($propertyName)
    {
        return $this->calculators[$propertyName] ?? null;
    }

    public function removeCalculator($propertyName)
    {
        unset($this->calculators[$propertyName]);
    }

    public function displayMortgageCalcForm($calc)
    {
        echo '
            <form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <label for="cloan_amount">Loan Amount:</label>
                <input type="number" id="cloan_amount" name="cloan_amount" step="0.01" value="' . $calc . '"><br><br>
                <label for="cinterest_rate">Interest Rate (% per annum):</label>
                <input type="cnumber" id="cinterest_rate" name="cinterest_rate" step="0.01" required><br><br>
                <label for="cloan_term">Loan Term (years):</label>
                <select name="cyears" id="cyears" required>
                    <option value="" selected disabled>Select Years</option>';
        for ($i = 35; $i >= 1; $i--) {
            echo '<option value="' . $i . '">' . $i . ' Year' . ($i !== 1 ? 's' : '') . '</option>';
        }
        echo '
                </select><br><br>
                <button type="submit" name="calculate">Calculate</button>
            </form>';
    }

    public function displayCalculationResult()
    {
        foreach ($this->calculators as $propertyName => $calculator) {
            echo '<h3>Monthly Repayment Details</h3>';
            echo '<form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            echo '<table>';
            echo '<tr>';
            echo '<th>Loan Amount</th>';
            echo '<th>Interest Rate</th>';
            echo '<th>Loan Term</th>';
            echo '<th>Monthly Repayment</th>';
            echo '<th>Total Interest</th>';
            echo '<th>Save</th>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>' . formatCurrency($calculator->getLoanAmount()) . '</td>';
            echo '<td>' . $calculator->getInterestRate() . '%</td>';
            echo '<td>' . $calculator->getLoanTermMonths() / 12 . ' Year' . ($calculator->getLoanTermMonths() / 12 !== 1 ? 's' : '') . '</td>';
            echo '<td>' . formatCurrency($calculator->getMonthlyRepayment()) . '</td>';
            echo '<td>' . formatCurrency($calculator->getTotalInterest()) . '</td>';
            // Hidden inputs to pass the calculator data
            echo '<input type="hidden" name="loan_amount" value="' . htmlspecialchars($calculator->getLoanAmount()) . '">';
            echo '<input type="hidden" name="interest_rate" value="' . htmlspecialchars($calculator->getInterestRate()) . '">';
            echo '<input type="hidden" name="loan_term_years" value="' . htmlspecialchars($calculator->getLoanTermMonths() / 12) . '">';
            echo '<input type="hidden" name="monthly_repayment" value="' . htmlspecialchars($calculator->getMonthlyRepayment()) . '">';
            echo '<input type="hidden" name="total_interest" value="' . htmlspecialchars($calculator->getTotalInterest()) . '">';
            echo '<td><button type="submit" name="save_calculation">Save</button></td>';
            echo '</tr>';
            echo '</table>';
            echo '</form>';
        }
    }

    public function saveCalculation($loanAmount, $interestRate, $loanTermYears, $monthlyRepayment, $totalInterest)
    {
        $loanAmount = number_format($loanAmount, 2, '', '');
        $monthlyRepayment = number_format($monthlyRepayment, 2, '', '');
        $totalInterest = number_format($totalInterest, 2, '', '');

        $sql = "INSERT INTO MortgageCalculations (user_id, loan_amount, interest_rate, loan_term_years, monthly_repayment, total_interest) VALUES ($this->buyerID, $loanAmount, $interestRate, $loanTermYears, $monthlyRepayment, $totalInterest)";
        $this->conn->query($sql);
    }

    public function deleteSavedCalculation($calculationID)
    {
        $sql = "DELETE FROM MortgageCalculations WHERE calculation_id = $calculationID";
        $this->conn->query($sql);
    }

    public function displaySavedCalculations()
    {   
        echo '<h3>Saved Calculations</h3>';
        $sql = "SELECT * FROM MortgageCalculations WHERE user_id = $this->buyerID";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Loan Amount</th>';
            echo '<th>Interest Rate</th>';
            echo '<th>Loan Term (Years)</th>';
            echo '<th>Monthly Repayment</th>';
            echo '<th>Total Interest</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                $calculation = [
                    'calculation_id' => $row['calculation_id'],
                    'loan_amount' => $row['loan_amount'],
                    'interest_rate' => $row['interest_rate'],
                    'loan_term_years' => $row['loan_term_years'],
                    'monthly_repayment' => $row['monthly_repayment'],
                    'total_interest' => $row['total_interest']
                ];
                echo '<tr>';
                echo '<td>' . formatCurrency(htmlspecialchars($calculation['loan_amount'])) . '</td>';
                echo '<td>' . htmlspecialchars($calculation['interest_rate']) . '%</td>';
                echo '<td>' . htmlspecialchars($calculation['loan_term_years']) . '</td>';
                echo '<td>' . formatCurrency(htmlspecialchars($calculation['monthly_repayment'])) . '</td>';
                echo '<td>' . formatCurrency(htmlspecialchars($calculation['total_interest'])) . '</td>';
                echo '<td><a href="mortgage_calculator.php?delete=' . htmlspecialchars($calculation['calculation_id']) . '">Delete</a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No saved calculations found.</p>';
        }
    }

}

function formatCurrency($amount)
{
    return '$' . number_format($amount, 2);
}

?>
