<?php
    // gets the data from the form
    $investment = filter_input(INPUT_POST, 'investment', 
            FILTER_VALIDATE_FLOAT);
    $interest_rate = filter_input(INPUT_POST, 'interest_rate', 
            FILTER_VALIDATE_FLOAT);
    $years = filter_input(INPUT_POST, 'years', 
            FILTER_VALIDATE_INT);
    
    //gets the data from the checkbox. Returns true if checkbox is checked and false if not checked
    $compound_monthly = $_POST['compound_monthly'];
    if (isset($compound_monthly)) {
        $compound_monthly = 'Yes';     
    }else{
        $compound_monthly = 'No';
    }

    // validate investment
    if ($investment === FALSE ) {
        $error_message = 'Investment must be a valid number.'; 
    } else if ( $investment <= 0 ) {
        $error_message = 'Investment must be greater than zero.'; 
    // validate interest rate
    } else if ( $interest_rate === FALSE )  {
        $error_message = 'Interest rate must be a valid number.'; 
    } else if ( $interest_rate <= 0 ) {
        $error_message = 'Interest rate must be greater than zero.'; 
    // validate years
    } else if ( $years === FALSE ) {
        $error_message = 'Years must be a valid whole number.';
    } else if ( $years <= 0 ) {
        $error_message = 'Years must be greater than zero.';
    } else if ( $years > 30 ) {
        $error_message = 'Years must be less than 31.';
    // set error message to empty string if no invalid entries
    } else {
        $error_message = ''; 
    }

    // if an error message exists, go to the index page
    if ($error_message != '') {
        include('index.php');
        exit();
    }


    
    // calculate the future value interest yearly.
    if ($compound_monthly == 'No') {
        $future_value = $investment; 
        for ($i = 1; $i <= $years; $i++) //{
        $future_value = ($future_value + ($future_value * $interest_rate *.01));
        
    } else {
        // calculate the future value interest monthly.
        $future_value = $investment;
        $months = $years * 12;
        $monthly_rate = $interest_rate / 12;
        for ($i = 1; $i <= $months; $i++) {
        $future_value = ($future_value + ($future_value * $monthly_rate *.01));
        //var_dump($monthly_rate);        
      
        }  
    }
      
    
    // apply currency and percent formatting
    $investment_f = '$'.number_format($investment, 2);
    $yearly_rate_f = $interest_rate.'%';
    $future_value_f = '$'.number_format($future_value, 2);
    $monthly_rate_f = $interest_rate.'%';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
    <main>
        <h1>Future Value Calculator</h1>

        <label>Investment Amount:</label>
        <span><?php echo $investment_f; ?></span><br>

        <label>Yearly Interest Rate:</label>
        <span><?php echo $yearly_rate_f; ?></span><br>

        <label>Number of Years:</label>
        <span><?php echo $years; ?></span><br>

        <label>Future Value:</label>
        <span><?php echo $future_value_f; ?></span><br>
        
        <label>Compound Monthly</label>
        <span><?php echo $compound_monthly; ?></span><br> <!--indicates if checkbox checked or not-->
    </main>
</body>
</html>