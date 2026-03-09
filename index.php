<?php
$voltage = $_POST['voltage'] ?? '';
$current = $_POST['current'] ?? '';
$hour    = $_POST['hour'] ?? '';
$rate    = $_POST['rate'] ?? '';

function calculateElectricity($voltage, $current, $hour, $rate) {
    $power = $voltage * $current;           // Watt
    $energy = ($power * $hour) / 1000;     // kWh
    $total = $energy * ($rate / 100);      // RM

    return [
        "power"  => $power,
        "energy" => $energy,
        "total"  => $total
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Electricity Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container mt-5">

    <h2 class="text-center mb-4">Electricity Consumption Calculator</h2>

    <div class="card shadow p-4">
        <form method="POST">

            <div class="form-group">
                <label>Voltage (V)</label>
                <input type="number" step="any" name="voltage" class="form-control" value="<?= $voltage ?>" required>
            </div>

            <div class="form-group">
                <label>Current (A)</label>
                <input type="number" step="any" name="current" class="form-control" value="<?= $current ?>" required>
            </div>

            <div class="form-group">
                <label>Usage Hours</label>
                <input type="number" step="any" name="hour" class="form-control" value="<?= $hour ?>" required>
            </div>

            <div class="form-group">
                <label>Electricity Rate (sen/kWh)</label>
                <input type="number" step="any" name="rate" class="form-control" value="<?= $rate ?>" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-2">Calculate</button>
            <a href="" class="btn btn-secondary btn-block">Reset</a>

        </form>
    </div>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
        <?php
        $power_kw = ($voltage * $current) / 1000;
        $rate_rm = $rate / 100;
        ?>

        <div class="card mt-4 shadow p-4">

            <h4 class="mb-3">Calculation Result</h4>

            <p><strong>POWER :</strong> <?= number_format($power_kw, 5) ?> kW</p>
            <p><strong>RATE :</strong> RM <?= number_format($rate_rm, 3) ?></p>

            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Hour</th>
                        <th>Energy (kWh)</th>
                        <th>Total (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= $hour; $i++) : ?>
                        <?php $result = calculateElectricity($voltage, $current, $i, $rate); ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $i ?></td>
                            <td><?= number_format($result["energy"], 5) ?></td>
                            <td><?= number_format($result["total"], 2) ?></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>

        </div>
    <?php endif; ?>

</div>
</body>
</html>