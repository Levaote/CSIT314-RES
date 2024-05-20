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

    public function displayMortgageCalcForm($calc) {
        echo '
            <form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <label for="loan_amount">Loan Amount:</label>
                <input type="number" id="loan_amount" name="loan_amount" step="0.01" value="' . $calc . '"><br><br>
                <label for="interest_rate">Interest Rate (% per annum):</label>
                <input type="number" id="interest_rate" name="interest_rate" step="0.01" required><br><br>
                <label for="loan_term">Loan Term (years):</label>
                <select name="years" id="years" required>
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
        function formatCurrency($amount)
        {
            return '$' . number_format($amount, 2);
        }
    
        foreach ($this->calculators as $propertyName => $calculator) {
            echo '<h3>Monthly Repayment Details</h3>';
            echo '<form method="POST" action="save_calculation.php">';
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
            echo '<input type="hidden" name="property_name" value="' . htmlspecialchars($propertyName) . '">';
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

    public function saveCalculation($propertyName)
    {
        $calculator = $this->getCalculator($propertyName);
        if ($calculator) {
            $loanAmount = $calculator->getLoanAmount();
            $interestRate = $calculator->getInterestRate();
            $loanTermYears = $calculator->getLoanTermMonths() / 12;
            $monthlyRepayment = $calculator->getMonthlyRepayment();
            $totalInterest = $calculator->getTotalInterest();
            $stmt = $this->conn->prepare("
                INSERT INTO MortgageCalculations (user_id, loan_amount, interest_rate, loan_term_years, monthly_repayment, total_interest) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->bindParam(1, $this->buyerID);
            $stmt->bindParam(2, $loanAmount);
            $stmt->bindParam(3, $interestRate);
            $stmt->bindParam(4, $loanTermYears);
            $stmt->bindParam(5, $monthlyRepayment);
            $stmt->bindParam(6, $totalInterest);
            $stmt->execute();
        }
    }

    public function getSavedCalculations()
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM MortgageCalculations WHERE user_id = ?
        ");
        $stmt->bindParam(1, $this->buyerID);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteSavedCalculation($calculationID)
    {
        $stmt = $this->conn->prepare("
            DELETE FROM MortgageCalculations WHERE user_id = ? AND calculation_id = ?
        ");
        $stmt->bindParam(1, $this->buyerID);
        $stmt->bindParam(2, $calculationID);
        $stmt->execute();
    }

    public function displaySavedCalculations(){
        echo '<h3>Saved Calculations</h3>';
        $calculations = $this->getSavedCalculations();
        if (count($calculations) > 0) {
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
            foreach ($calculations as $calculation) {
                echo '<tr>';
                echo '<td>' . $calculation['loan_amount'] . '</td>';
                echo '<td>' . $calculation['interest_rate'] . '</td>';
                echo '<td>' . $calculation['loan_term_years'] . '</td>';
                echo '<td>' . $calculation['monthly_repayment'] . '</td>';
                echo '<td>' . $calculation['total_interest'] . '</td>';
                echo '<td><a href="mortgage_calculator.php?delete=' . $calculation['calculation_id'] . '">Delete</a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No saved calculations found.</p>';
        }
    }
}
?>
