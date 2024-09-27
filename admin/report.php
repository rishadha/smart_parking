<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Parking (Pvt) Ltd: Monthly Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        h3 {
            margin-bottom: 5px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 style="text-align: center;">Smart Parking (Pvt) Ltd: Monthly Report</h2>

        <div class="summary">
            <h3>Overview</h3>
            <p style="text-align: justify;">Smart Parking (Pvt) Ltd is dedicated to providing innovative parking
                solutions to our clients. This report highlights key activities and achievements for the month of
                <?php echo date('F, Y'); ?>.
            </p>
        </div>

        <br />
        <div class="operational-updates">
            <h3>Operational Updates</h3>
            <h4>Parking Facility Utilization</h4>
            <p>Total number of parking spaces available:
                <?php echo $total_spaces; ?>
            </p>

            <p>Peak occupancy hours:08:00 AM - 09:00 AM</p>

            <h4>Customer Feedback</h4>
            <p style="text-align: justify;">Collated feedback from customers
                regarding parking experience and service quality and
                Implemented measures to improve parking facility operations
                and address customer complaints promptly.</p>
        </div><br />

        <div class="financial-performance">
            <h3>Financial Performance</h3>
            <p>Total revenue generated: [Amount]</p>
            <table>
                <thead>
                    <tr>
                        <th>Revenue Source</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Parking fees</td>
                        <td>Rs.30</td>
                    </tr>
                    <tr>
                        <td>curent Transection amount </td>
                        <td>
                            <?php echo $total_amount_rupees; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>curent Transection amount in Dollers </td>
                        <td>
                            <?php echo $total_amount_dollars_formatted; ?>
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>

        <br />
        <div class="maintenance-and-upgrades">
            <h3>Maintenance and Upgrades</h3>
            <p style="text-align: justify;">
                Upgrades implemented to improve user experience and operational efficiency.
                This section provides a concise overview of the maintenance tasks performed to
                ensure the smooth operation and upkeep of our parking facilities.</p>
        </div>

        <br />
        <div class="marketing-and-outreach">
            <h3>Marketing and Outreach</h3>

            <p style="text-align: justify;">Partnerships established with local businesses or organizations
                outlines the marketing strategies and outreach efforts
                undertaken to promote our parking services and engage
                with potential clients and partners.
            </p>
        </div>

        <br />
        <div class="future-plans">
            <h3>Future Plans</h3>
            <p style="text-align: justify;">
                We aim to enhance service quality and customer
                satisfaction by implementing initiatives such
                as introducing a loyalty rewards program for frequent
                parkers, enhancing security measures with the
                installation of additional CCTV cameras, and expanding
                our reservation system to offer more convenience to
                customers. Additionally, we plan to conduct customer
                satisfaction surveys to gather feedback and make further
                improvements based on their suggestions.

            </p>
        </div>

        <br />
        <div class="conclusion">
            <h3>Conclusion</h3>
            <p style="text-align: justify;">Smart Parking (Pvt) Ltd remains committed
                to providing top-notch parking services
                and enhancing customer experience.
                We thank our clients for their continued support
                and look forward to another successful month ahead.</p>
        </div>
    </div>
    <?php
    // Include the database connection file
    require_once './database.php';
    $db = new Database();
    $conn = $db->getConnection();

    /// Retrieve data from the 'transactions' table
    $sql = "SELECT SUM(payment) AS total_amount_rupees FROM transactions";
    $result = $conn->query($sql);

    $sql_dollars = "SELECT SUM(payment_in_usd) AS total_amount_dollars FROM transactions";
    $result_dollars = $conn->query($sql_dollars);

    // Initialize variables to hold the total amounts
    $total_amount_rupees = 0;
    $total_amount_dollars = 0;

    // Check if there are any transactions
    if ($result !== false) {
        // Fetch the total transaction amount
        $row = $result->fetch_assoc();
        $total_amount = $row['total_amount_rupees'];
    } else {
        // No transactions found
        $total_amount = 0;
    }

    if ($result_dollars->num_rows > 0) {
        $row_dollars = $result_dollars->fetch_assoc();
        $total_amount_dollars = $row_dollars['total_amount_dollars'];
    }
    $total_amount_dollars_formatted = number_format($total_amount_dollars, 2) . " USD";
    // Format the total amount in rupees
    $total_amount_rupees = " RS." . number_format($total_amount, 2);


    $sql = "SELECT COUNT(*) AS total_spaces FROM slot WHERE status = 'in'";
    $result = $conn->query($sql);

    // Initialize variable to hold the total number of spaces
    $total_spaces = 0;
    $totalSlot = 16;
    // Fetch the total number of spaces
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_spaces = $totalSlot - $row['total_spaces'];
    }


    // Close the database connection
    $conn->close();
    ?>
</body>

</html>