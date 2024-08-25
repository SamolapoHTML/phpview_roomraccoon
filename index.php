
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesego - RoomRaccoon Assessment</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="heading">
            <p style="float: left;">Revenue</p>
            <button onclick="openPopup()" style="float: right;" class="next-btn">Add Revenue</button>
        </div>
        <div id="dataPopup" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closePopup()">&times;</span>
                <h2>Insert Revenue</h2>
                <form id="insertForm" method="post" action="insert_data.php">
                    <label for="room_revenue">Room Revenue:</label>
                    <input type="number" id="room_revenue" name="room_revenue" required><br><br>

                    <label for="add_ons">Add-ons:</label>
                    <input type="number" id="add_ons" name="add_ons" required><br><br>

                    <label for="adr">ADR:</label>
                    <input type="number" id="adr" name="adr" required><br><br>

                    <label for="rev_par">RevPAR:</label>
                    <input type="number" id="rev_par" name="rev_par" required><br><br>

                    <button type="submit" class="next-btn">Insert Data</button>
                </form>
            </div>
        </div>
        <div class="navbar">
            <ul>
                <li><a href="#" class="active">Summary</a></li>
                <li><a href="#">Reservation Channels</a></li>
                <li><a href="#">Monthly Pickup</a></li>
                <li><a href="#">External Revenue</a></li>
                <li><a href="#">Yearly Metrics</a></li>
            </ul>
        </div>
        <div class="heading downloadsection">
            <input id="compareDate" style="float: left; margin-top: 1px; margin-right: 10px;float: left;padding: 8px; margin-top: 1px;border-radius: 10px;" placeholder="Calendar: August 2023" type="text" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
            <input id="compareToDate" style="float: left; margin-top: 1px;padding: 8px; margin-top: 1px;border-radius: 10px;" placeholder="Compare: August 2023" type="text" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
            <button onclick="downloadTable('xlsx')" style="float: right; margin-right: 10px;" class="next-btn">Download XLSX</button>
        </div>
        <div class="tab-content">
            <div class="section-container">
                <div class="section">
                    <div class="chart-container">
                        <p>Total Revenue</p>
                        <div class="totalperformance">
                            <?php
                            $servername = "localhost"; 
                            $username = "nnhqxdpc_roomradashuser"; 
                            $password = "SplashParkedMenaceSalved12";  
                            $dbname = "nnhqxdpc_roomradash"; 

                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $totals_sql = "SELECT SUM(room_revenue) AS total_room_revenue, SUM(add_ons) AS total_add_ons, 
                                            SUM(adr) AS total_adr, SUM(rev_par) AS total_rev_par FROM roomradash";
                            $totals_result = $conn->query($totals_sql);
                            $totals = $totals_result->fetch_assoc();

                            $total_sum = $totals['total_room_revenue'] + $totals['total_add_ons'] + $totals['total_adr'] + $totals['total_rev_par'];
                            echo '<p class="totalrevenue">R' . number_format($total_sum, 2, ',', '.') . '</p>';

                            $conn->close();
                            ?>
                        </div>
                        <canvas id="chart1"></canvas>
                    </div>
                </div>
                <div class="section">
                    <div class="chart-container">
                        <p>Occupancy <span class="smallfont">(out of 20 available rooms)</span></p>
                        <div class="totalperformance">
                            <?php
                            $servername = "localhost";
                            $username = "nnhqxdpc_roomradashuser";
                            $password = "SplashParkedMenaceSalved12";
                            $dbname = "nnhqxdpc_roomradash";

                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $current_month = date('Y-m');
                            $current_month_sql = "SELECT COUNT(*) AS total_entries FROM roomradash WHERE DATE_FORMAT(date, '%Y-%m') = '$current_month'";
                            $current_month_result = $conn->query($current_month_sql);
                            $current_month_data = $current_month_result->fetch_assoc();
                            $current_entries = $current_month_data['total_entries'];
                            $percentage_current = ($current_entries / 20) * 100;
                            $previous_month = date('Y-m', strtotime('-1 month'));
                            $previous_month_sql = "SELECT COUNT(*) AS total_entries FROM roomradash WHERE DATE_FORMAT(date, '%Y-%m') = '$previous_month'";
                            $previous_month_result = $conn->query($previous_month_sql);
                            $previous_month_data = $previous_month_result->fetch_assoc();
                            $previous_entries = $previous_month_data['total_entries'];
                            $percentage_previous = ($previous_entries / 20) * 100;

                            $percentage_difference = $percentage_current - $percentage_previous;
                            $color_class = $percentage_difference >= 0 ? 'increase' : 'decrease';

                            echo '<p class="totalrevenue">
                                    ' . number_format($percentage_current,0) . '% 
                                </p>';
                            echo '<p class="percentage-difference ' . $color_class . '">
                                   ' . number_format($percentage_difference, 0) . '% 
                                </p>';

                            $conn->close();
                            ?>
                        </div>
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
            </div>
            <?php
            $servername = "localhost"; 
            $username = "nnhqxdpc_roomradashuser"; 
            $password = "SplashParkedMenaceSalved12";  
            $dbname = "nnhqxdpc_roomradash"; 

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $results_per_page = 10;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $start_from = ($page - 1) * $results_per_page;

            $sql = "SELECT date, room_revenue, add_ons, adr, rev_par FROM roomradash LIMIT $start_from, $results_per_page";
            $result = $conn->query($sql);

            $total_sql = "SELECT COUNT(*) FROM roomradash";
            $total_result = $conn->query($total_sql);
            $total_rows = $total_result->fetch_row()[0];
            $total_pages = ceil($total_rows / $results_per_page);

            $page_total_room_revenue = 0;
            $page_total_add_ons = 0;
            $page_total_adr = 0;
            $page_total_rev_par = 0;

            if ($result->num_rows > 0) {
                echo '<table>
                        <div class="table-head">
                            <p>Revenue metrics</p>
                        </div>';

                while($row = $result->fetch_assoc()) {
                    $page_total_room_revenue += $row["room_revenue"];
                    $page_total_add_ons += $row["add_ons"];
                    $page_total_adr += $row["adr"];
                    $page_total_rev_par += $row["rev_par"];
                }

                $result->data_seek(0);

                echo '<thead>
                        <tr>
                            <th>Date</th>
                            <th>Room Revenue</th>
                            <th>Add-ons</th>
                            <th>ADR</th>
                            <th>RevPAR</th>
                        </tr>
                    </thead>
                    <tbody>';

                echo '<thead>
                    <tr>
                        <th><strong>Total</strong></th>
                        <th><strong>R' . number_format($totals['total_room_revenue'], 2, ',', '.') . '</strong></th>
                        <th><strong>R' . number_format($totals['total_add_ons'], 2, ',', '.') . '</strong></th>
                        <th><strong>R' . number_format($totals['total_adr'], 2, ',', '.') . '</strong></th>
                        <th><strong>R' . number_format($totals['total_rev_par'], 2, ',', '.') . '</strong></th>
                    </tr>
                </thead>';

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["date"] . "</td>
                            <td>R" . number_format($row["room_revenue"], 2, ',', '.') . "</td>
                            <td>R" . number_format($row["add_ons"], 2, ',', '.') . "</td>
                            <td>R" . number_format($row["adr"], 2, ',', '.') . "</td>
                            <td>R" . number_format($row["rev_par"], 2, ',', '.') . "</td>
                        </tr>";
                }

                echo '</tbody></table>';
            } else {
                echo "0 results";
            }

            echo '<div class="pagination">';
            if ($page > 1) {
                echo '<a href="?page=' . ($page - 1) . '" class="previous-btn">Previous</a>';
            }
            if ($page < $total_pages) {
                echo '<div class="next-block">';
                echo '<a href="?page=' . ($page + 1) . '" class="next-btn">Next</a>';
                echo '<span class="next-count">' . ($total_pages - $page) . '</span>';
                echo '</div>';
            }
            echo '</div>';

            $conn->close();
            ?>

        </div>
    </div>

    <script>
    async function fetchChartData() {
    const response = await fetch('fetch_chart_data.php'); 
    const data = await response.json();

    // Define month names and calculate the current and previous month
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const currentDate = new Date();
    const currentMonthIndex = currentDate.getMonth();
    const currentYear = currentDate.getFullYear();
    const currentMonth = monthNames[currentMonthIndex];
    
    // Calculate previous month and handle year transition
    const previousMonthIndex = (currentMonthIndex - 1 + 12) % 12;
    const previousYear = previousMonthIndex === 11 ? currentYear - 1 : currentYear;
    const previousMonth = monthNames[previousMonthIndex];

    // Define the labels for the current and previous months
    const xAxisLabels = [`1 ${currentMonth}`, `5 ${currentMonth}`, `10 ${currentMonth}`, `15 ${currentMonth}`, `20 ${currentMonth}`, `25 ${currentMonth}`, `30 ${currentMonth}`];
    const xAxisLabelsPreviousMonth = [`1 ${previousMonth}`, `5 ${previousMonth}`, `10 ${previousMonth}`, `15 ${previousMonth}`, `20 ${previousMonth}`, `25 ${previousMonth}`, `30 ${previousMonth}`];

    // Define datasets for the current and previous month’s revenue
    const revenueData = {
        labels: xAxisLabels,
        datasets: [
            {
                label: `Current Month (${currentMonth}) Revenue`,
                data: data.current_month_revenue,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.4
            },
            {
                label: `Previous Month (${previousMonth}) Revenue`,
                data: data.previous_month_revenue,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                tension: 0.4
            }
        ]
    };

    // Create the first chart for revenue data
    const ctx1 = document.getElementById('chart1').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: revenueData,
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(tooltipItems) {
                            const index = tooltipItems[0].dataIndex;
                            return revenueData.labels[index] || ''; // Correct label for tooltip
                        },
                        label: function(tooltipItem) {
                            const datasetLabel = tooltipItem.dataset.label || '';
                            return `${datasetLabel}: R${tooltipItem.raw.toLocaleString()}`; // Format the value
                        }
                    }
                },
                legend: {
                    labels: {
                        generateLabels: function(chart) {
                            const original = Chart.defaults.plugins.legend.labels.generateLabels(chart);
                            return original.map(label => {
                                // Update label text to include month names
                                if (label.text.includes('Current Month')) {
                                    label.text = `Current Month (${currentMonth}) Revenue`;
                                } else if (label.text.includes('Previous Month')) {
                                    label.text = `Previous Month (${previousMonth}) Revenue`;
                                }
                                return label;
                            });
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R' + value.toLocaleString(); // Format as Rand currency
                        }
                    }
                },
                x: {
                    ticks: {
                        callback: function(value, index) {
                            return revenueData.labels[index] || ''; // Return formatted date
                        }
                    }
                }
            }
        }
    });

    // Define datasets for the current and previous month’s entries
    const entriesData = {
        labels: xAxisLabels,
        datasets: [
            {
                label: `Current Month (${currentMonth}) Entries`,
                data: data.current_month_entries,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2,
                tension: 0.4
            },
            {
                label: `Previous Month (${previousMonth}) Entries`,
                data: data.previous_month_entries,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2,
                tension: 0.4
            }
        ]
    };

    // Create the second chart for entries data
    const ctx2 = document.getElementById('chart2').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: entriesData,
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(tooltipItems) {
                            const index = tooltipItems[0].dataIndex;
                            return entriesData.labels[index] || ''; // Correct label for tooltip
                        },
                        label: function(tooltipItem) {
                            const datasetLabel = tooltipItem.dataset.label || '';
                            return `${datasetLabel}: ${tooltipItem.raw.toLocaleString()}`; // Format the value
                        }
                    }
                },
                legend: {
                    labels: {
                        generateLabels: function(chart) {
                            const original = Chart.defaults.plugins.legend.labels.generateLabels(chart);
                            return original.map(label => {
                                // Update label text to include month names
                                if (label.text.includes('Current Month')) {
                                    label.text = `Current Month (${currentMonth}) Entries`;
                                } else if (label.text.includes('Previous Month')) {
                                    label.text = `Previous Month (${previousMonth}) Entries`;
                                }
                                return label;
                            });
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString(); // Format normally for entries
                        }
                    }
                },
                x: {
                    ticks: {
                        callback: function(value, index) {
                            return entriesData.labels[index] || ''; // Return formatted date
                        }
                    }
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', fetchChartData);

function openPopup() {
    document.getElementById("dataPopup").style.display = "block";
}

function closePopup() {
    document.getElementById("dataPopup").style.display = "none";
}

window.onclick = function(event) {
    var modal = document.getElementById("dataPopup");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Get the current date
const currentDate = new Date();

// Extract the current month and year
const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const currentMonth = monthNames[currentDate.getMonth()];
const currentYear = currentDate.getFullYear();

// Set the initial placeholder
document.getElementById('compareDate').placeholder = `Calendar: ${currentMonth} ${currentYear}`;
document.getElementById('compareToDate').placeholder = `Compare: ${currentMonth} ${currentYear}`;
    </script>
<script>
function downloadTable(fileType) {
    const table = document.querySelector('table');
    const rows = Array.from(table.querySelectorAll('tr')).map(row => 
        Array.from(row.querySelectorAll('th, td')).map(cell => 
            cell.textContent
        ).join(',')
    ).join('\n');

    if (fileType === 'csv') {
        downloadCSV(rows);
    } else if (fileType === 'xlsx') {
        downloadXLSX(table);
    }
}

function downloadCSV(csv) {
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'table-data.csv';
    a.click();
    URL.revokeObjectURL(url);
}

function downloadXLSX(table) {
    const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });
    const blob = new Blob([wbout], { type: 'application/octet-stream' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'table-data.xlsx';
    a.click();
    URL.revokeObjectURL(url);
}
console.log("Data fetched:", data);
console.log("Current Month Index:", currentMonthIndex);
console.log("Previous Month Data:", data.previous_month_revenue);
</script>

</body>
</html>
