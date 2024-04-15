<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
 <h1>Calculator</h1>
</header>
    <div class="calculator-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='post'>
            <input type="number" name="num1" placeholder="Number one" required>
            <select name="operator">
                <option value="add">+</option>
                <option value="subtract">-</option>
                <option value="multiply">*</option>
                <option value="divide">/</option>
            </select>
            <input type="number" name="num2" placeholder="Number two" required>
            <button>Calculate</button>
        </form>

<?php
class Calculator {
    private $num1;
    private $num2;
    private $operator;

    public function __construct($num1, $num2, $operator) {
        $this->num1 = $num1;
        $this->num2 = $num2;
        $this->operator = $operator;
    }

    public function calculate() {
        $errors = $this->validate();
        if (!$errors) {
            switch ($this->operator) {
                case 'add':
                    return $this->num1 + $this->num2;
                case 'subtract':
                    return $this->num1 - $this->num2;
                case 'multiply':
                    return $this->num1 * $this->num2;
                case 'divide':
                    return $this->num1 / $this->num2;
                default:
                    return "Something went wrong!";
            }
        } else {
            return $errors;
        }
    }

    // validate inputs
    private function validate() {
        $errors = array();
        if (empty($this->num1) || empty($this->num2) || empty($this->operator)) {
            $errors[] = "Fill in all fields!";
        }
        if (!is_numeric($this->num1) || !is_numeric($this->num2)) {
            $errors[] = "Only write numbers!";
        }
        return $errors;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num1 = filter_input(INPUT_POST, 'num1', FILTER_SANITIZE_NUMBER_FLOAT);
    $num2 = filter_input(INPUT_POST, 'num2', FILTER_SANITIZE_NUMBER_FLOAT);
    $operator = htmlspecialchars($_POST['operator']);

    $calculator = new Calculator($num1, $num2, $operator);

    $result = $calculator->calculate();

    // display result or errors
    if (is_numeric($result)) {
        echo "<p class='calc-result'>Result = " . $result . "</p>";
    } else {
        foreach ($result as $error) {
            echo "<p class='calc-error'>$error</p>";
        }
    }
}
?>
</div>
<footer>
        <p>&copy; <?php echo date("Y"); ?> Dana Popa</p>
    </footer>
</body>
</html>
