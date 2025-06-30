<?php
function gradeToPoint($grade) {
  $scale = [
    "A+" => 4.00, "A" => 4.00, "A-" => 3.70, "B+" => 3.30,
    "B" => 3.00, "B-" => 2.70, "C+" => 2.30, "C" => 2.00,
    "C-" => 1.70, "D" => 1.00, "I" => 0.0
  ];
  $grade = strtoupper(trim($grade));
  return $scale[$grade] ?? null;
}

$terms = $_POST['term'] ?? [""];
$courses = $_POST['course'] ?? [""];
$credits = $_POST['credits'] ?? [""];
$grades = $_POST['grade'] ?? [""];

$gpa = null;
if (isset($_POST['calculate'])) {
  $totalPoints = 0;
  $totalCredits = 0;

  for ($i = 0; $i < count($credits); $i++) {
    $cr = floatval($credits[$i]);
    $gp = gradeToPoint($grades[$i]);
    if ($gp !== null && $cr > 0) {
      $totalPoints += $gp * $cr;
      $totalCredits += $cr;
    }
  }

  if ($totalCredits > 0) {
    $gpa = round($totalPoints / $totalCredits, 2);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GPA Calculator</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="header-container">
      <div><h1>GPA Calculator</h1></div>
      <div class="header-nav">
        <p>Calculate your GPA easily!</p>
        <p><a href="">About</a></p>
        <p><a href="">Back to home</a></p>
      </div>
    </div>
  </header>

  <main>
    <div class="free-premium">
      <div class="free"><p>FREE</p></div>
      <div class="premium"><p>PREMIUM</p></div>
    </div>
    <div class="name"><h1>GPA Calculator</h1></div>

    <div class="GPA-calculator-area">
      <form method="post">
        <label class="uniname" for="University">SELECT YOUR UNIVERSITY: </label>
        <select name="university" id="university">
          <option value="" disabled selected style="color: gray;">Select your University from here</option>
          <option value="uom">University of Moratuwa</option>
        </select>

        <table id="gpaTable">
          <thead>
            <tr>
              <th>Term</th>
              <th>Course</th>
              <th>Credits<br>or hours</th>
              <th>Grade</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <?php
            $count = max(count($terms), 1);
            for ($i = 0; $i < $count; $i++) {
              echo '<tr>';
              echo '<td><input type="text" name="term[]" placeholder="naween"></td>';
              echo '<td><input type="text" name="course[]" value="' . htmlspecialchars($courses[$i] ?? '') . '"></td>';
              echo '<td><input type="number" step="0.1" name="credits[]" value="' . htmlspecialchars($credits[$i] ?? '') . '"></td>';
              echo '<td><input type="text" name="grade[]" value="' . htmlspecialchars($grades[$i] ?? '') . '"></td>';
              echo '<td><span class="remove-btn" onclick="removeRow(this)">×</span></td>';
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>

        <div class="controls">
          Number of rows to add:
          <input type="number" id="rowCount" value="1" min="1";>
          <button class="btn0" type="button" onclick="addRows()">Add</button>
          <button class="btn2" type="button" onclick="clearAll()">Clear all</button>
        </div>

        <button class="btn" type="submit" name="calculate">Calculate GPA</button>
        
      </form>

      <?php if ($gpa !== null): ?>
        <div class="gpaDisplay">Your GPA is: <?= $gpa ?></div>
      <?php endif; ?>
    </div>

    <div class="instruction-area">
      <h1>GPA Calculation Process</h1>
        <p>To calculate GPA (Grade Point Average), follow these steps:</p>
      <ol>
        <li>Convert each letter grade to a grade point using a standard scale (e.g., A = 4.00, B = 3.00, etc.).</li>
        <li>Multiply each course's credit hours by its corresponding grade point to get the quality points.</li>
        <li>Add up all the quality points for all courses.</li>
        <li>Divide the total quality points by the total credit hours.</li>
      </ol>

      <table>
        <thead>
          <tr>
            <th>Course</th>
            <th>Credits</th>
            <th>Grade</th>
            <th>Grade Point</th>
            <th>Quality Point</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Math</td>
            <td>3</td>
            <td>A</td>
            <td>4.00</td>
            <td>3*4.00=12.00</td>
          </tr>
          <tr>
            <td>Math</td>
            <td>3</td>
            <td>A</td>
            <td>4.00</td>
            <td>3*4.00=12.00</td>
          </tr>
        </tbody>
      </table>
        <ul>
          <li>Total Quality Points = 18.00</li>
          <li>Total Credits = 5</li>
          <li>GPA = 18.00 ÷ 5 = 3.60</li>
        </ul>
    </div>
        <div class="nnnn">
          <p>University of Moratuwa BIT Grading system</p>
        </div>
    <div class="table">
      <table>
        <thead>
          <tr>
            <th>Benchmark Percentage</th>
            <th>Grade</th>
            <th>Grade Point</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>85 and Above</td><td>A+</td><td>4.00</td><td rowspan="3">Excellent</td></tr>
          <tr><td>75 to 84</td><td>A</td><td>4.00</td></tr>
          <tr><td>70 to 74</td><td>A-</td><td>3.70</td></tr>
          <tr><td>65 to 69</td><td>B+</td><td>3.30</td><td rowspan="3">Good</td></tr>
          <tr><td>60 to 64</td><td>B</td><td>3.00</td></tr>
          <tr><td>55 to 59</td><td>B-</td><td>2.70</td></tr>
          <tr><td>50 to 54</td><td>C+</td><td>2.30</td><td rowspan="2">Pass</td></tr>
          <tr><td>45 to 49</td><td>C</td><td>2.00</td></tr>
          <tr><td>40 to 44</td><td>C-</td><td>1.70</td><td>Weak pass</td></tr>
          <tr><td>35 to 39</td><td>D</td><td>1.00</td><td>Conditional pass</td></tr>
          <tr><td>34 and Below</td><td>I</td><td>0.00</td><td>Incomplete</td></tr>
        </tbody>
      </table>
    </div>
    <section class="source">
  <h3>Source</h3>
  <p>The GPA grade points are based on the official scale from 
    <a href="https://bit.uom.lk/bituom/" target="_blank">University of Moratuwa BIT Program (External)</a>.
  </p>
</section>

  </main>
  <footer>
        <div class="footer-content">
            <p>&copy; 2025 Developed by Naween Kanishka</p>
        </div>
    </footer>

  <script>
    function addRows() {
      let count = parseInt(document.getElementById("rowCount").value);
      const tbody = document.getElementById("tableBody");
      for (let i = 0; i < count; i++) {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td><input type="text" name="term[]"></td>
          <td><input type="text" name="course[]"></td>
          <td><input type="number" step="0.1" name="credits[]"></td>
          <td><input type="text" name="grade[]"></td>
          <td><span class="remove-btn" onclick="removeRow(this)">×</span></td>
        `;
        tbody.appendChild(row);
      }
    }

    function removeRow(el) {
      el.closest("tr").remove();
    }

    function clearAll() {
      const tbody = document.getElementById("tableBody");
      tbody.innerHTML = "";
      const row = document.createElement("tr");
      row.innerHTML = `
        <td><input type="text" name="term[]"></td>
        <td><input type="text" name="course[]"></td>
        <td><input type="number" step="0.1" name="credits[]"></td>
        <td><input type="text" name="grade[]"></td>
        <td><span class="remove-btn" onclick="removeRow(this)">×</span></td>
      `;
      tbody.appendChild(row);
    }
  </script>
</body>
</html>
