<?php
require_once '../db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = isset($_POST['start_date']) ? trim($_POST['start_date']) : null;
    $end_date = isset($_POST['end_date']) ? trim($_POST['end_date']) : null;

    if ($start_date && $end_date) {
        try {
            $stmt = $conn->prepare("
                SELECT i.id, i.contact_id, i.interaction_type, i.date, i.notes, i.follow_up_date, i.status, u.name AS user_name
                FROM interactions i
                JOIN users u ON i.user_id = u.id
                WHERE i.date BETWEEN :start_date AND :end_date
                ORDER BY i.date DESC
            ");

            $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
            $stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);
            $stmt->execute();
            $interactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    } else {
        echo "Please provide a valid date range.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <link rel="stylesheet" href="../../style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- For icons -->
</head>
<style>
    .title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.date-range-form {
    width: 50%;
    margin: 40px auto;
    padding: 20px;
    background-color: #f7f7f7;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #666;
}

.form-group input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit-btn:hover {
    background-color: #3e8e41;
}

.report-title {
    margin-top: 20px;
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.report-table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.report-table th, .report-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.report-table th {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}

.report-table tr:hover {
    background-color: #f1f1f1;
}

.no-results {
    text-align: center;
    margin-top: 20px;
    font-size: 18px;
    color: #666;
}
</style>
<body>
<div class="sidebar">
    <h2>CRM Admin</h2>
    <ul>
        <li><a href="../dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        
        <!-- Contacts Dropdown -->
        <li class="dropdown">
            <a href="../contacts/view.php" class="dropbtn"><i class="fas fa-user"></i> Contacts</a>
        </li>
        
        <!-- Interactions Dropdown -->
        <li class="dropdown">
            <a href="interaction_report.php" class="dropbtn"><i class="fas fa-comments"></i> Interactions</a>
        </li>
        
        <!-- Notes Dropdown -->
        <li class="dropdown">
            <a href="../notes/view.php" class="dropbtn"><i class="fas fa-sticky-note"></i> Notes</a>
        </li>
        
        <!-- Tasks Dropdown -->
        <li class="dropdown">
            <a href="../tasks/view.php" class="dropbtn"><i class="fas fa-tasks"></i> Tasks</a>
        </li>
       
    </ul>
</div>

    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="user-info">
              
                <a style="color: black;font-size:larger ; margin-left:59rem" href="logout.php" > <i style="font-size: x-large;color:black" class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
            <header>
                <h1 style="margin-top:3rem;text-align:center">Interaction Report</h1>
            </header>




<form method="POST" class="date-range-form">
    <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" required>
    </div>

    <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" required>
    </div>

    <button type="submit" class="submit-btn">Generate Report</button>
</form>

<?php if (!empty($interactions)): ?>
    <h3 class="report-title">Interactions from <?= htmlspecialchars($start_date) ?> to <?= htmlspecialchars($end_date) ?></h3>
    <table class="report-table">
        <thead>
            <tr>
                <th>Contact ID</th>
                <th>Type</th>
                <th>Date</th>
                <th>Notes</th>
                <th>Follow-up Date</th>
                <th>Status</th>
                <th>Handled By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($interactions as $interaction): ?>
                <tr>
                    <td><?= htmlspecialchars($interaction['contact_id']) ?></td>
                    <td><?= htmlspecialchars($interaction['interaction_type']) ?></td>
                    <td><?= htmlspecialchars($interaction['date']) ?></td>
                    <td><?= htmlspecialchars($interaction['notes']) ?></td>
                    <td><?= htmlspecialchars($interaction['follow_up_date']) ?></td>
                    <td><?= htmlspecialchars($interaction['status']) ?></td>
                    <td><?= htmlspecialchars($interaction['user_name']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p class="no-results">No interactions found for the selected date range.</p>
<?php endif; ?>
          
    </div>

   <script src="../style.js"></script>
</body>
</html>