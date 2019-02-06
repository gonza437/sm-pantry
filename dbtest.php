<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>Cougar-Pantry</title>
    </head>
    <body>
        <header>
        <?php
            class Month
            {
                function Month() 
                {
                    $this->months = "A";
                    $this->day = array();
                    $this->employee = array();
                    $this->donate = array();
                    $this->cost = array();
                    $this->m_employee = 0;
                    $this->m_donate = 0;
                    $this->m_cost = 0;
                }
            }
            //fix this
            //------------------------------------------------------------------
            //$conn = getDB();
            $one = getdata('SELECT * FROM years WHERE Months=\'January\'');
            $two = getdata('SELECT * FROM years WHERE Months=\'February\'');
            $three = getdata('SELECT * FROM years WHERE Months=\'March\'');
            $four = getdata('SELECT * FROM years WHERE Months=\'April\'');
            $five = getdata('SELECT * FROM years WHERE Months=\'May\'');
            //------------------------------------------------------------------
            function getDB() 
            {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "dbtest";
                
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                //echo "Connected successfully";
                
                return $conn;
             }
            function getdata($input)
            {
                //fix later
                //--------------------------------------------------------------
                $conn = getDB();
                //--------------------------------------------------------------
                $sql = $input;
                $result = $conn->query($sql);
                
                $data = new Month();
                
                $i = 0;
                        
                if ($result->num_rows > 0) 
                {
                    // output data of each row
                    while($row = $result->fetch_assoc()) 
                    {
                        $data->months = $row['Months'];
                        $data->employee[$i] = $row['Employee'];
                        $data->donate[$i] = $row['Donate'];
                        $data->cost[$i] = $row['Cost'];
                        $data->day[$i] = $row['day'];
                        
                        $data->m_employee += $row['Employee'];
                        $data->m_donate += $row['Donate'];
                        $data->m_cost += $row['Cost'];
                        $i++;
                    }
                }
                else
                {
                    echo 'no';
                }
                
              return $data;
            }
        ?> 
        
        </header>
        
        <main>
            <div id = 'main_chart'></div>
           
                <button id = 'First' onClick = 'changeChart(this.id)'>First Quarter</button>
                <button id = 'Second'  onClick = 'changeChart(this.id)'>Second Quarter</button>
                <button>Third Quarter</button>
                <button>Fourth Quarter</button>
            <div id='chart_di'></div>
        </main>

        <footer>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                var dat = null;
                var dat2 = null;
                //fix this 
                //--------------------------------------------------------------
                var one, two, three, four, five;
                //--------------------------------------------------------------
                
                google.charts.load('current', {packages: ['corechart', 'bar']});
                google.charts.setOnLoadCallback(function () 
                {
                    data = filldata(true);
                    //dat2 = filldata(true)
                    
                    drawChart(data, true);
                    drawChart(data, false);
                });
        
                function filldata(flag)
                {
                    //----------------------------------------------------------
                    one= <?php echo json_encode($one); ?>;
                    two= <?php echo json_encode($two); ?>;
                    three= <?php echo json_encode($three); ?>;
                    four= <?php echo json_encode($four); ?>;
                    five = <?php echo json_encode($five); ?>;
                    //----------------------------------------------------------
                    
                    var data = google.visualization.arrayToDataTable([
                        ['Months', '# of students', 'Total Cost', '# of Labor'],
                        ['m', 0, 0, 0],
                        ]);
                    data.removeRow(0);
                    if(flag)
                    {
                        data.addRow([one.months, one.m_donate, one.m_cost, one.m_employee]);
                        data.addRow([two.months, two.m_donate, two.m_cost, two.m_employee]);
                        data.addRow([three.months, three.m_donate, three.m_cost, three.m_employee]);
                        data.addRow([four.months, four.m_donate, four.m_cost, four.m_employee]);
                        console.log("he");
                    }
                    else if(!flag)
                    {
                        //console.log('k');
                        //console.log(one.donate[0]);
                        //var apple = 459;
                        data.addRow(['day', apple, one.m_cost, one.m_employee]);
                       // data.addRow(['day', one.donate[0], one.cost[0], one.employee[0]]);
                        //data.addRow([one.day[1], one.donate[1], one.cost[1], one.employee[1]]);
                       // data.addRow([one.day[2], one.donate[2], one.cost[2], one.employee[2]]);
                        //data.addRow([one.day[3], one.donate[3], one.cost[3], one.employee[3]]);
                        console.log('k');
                    }
                    return data;
                }
                function drawChart(data, flag)
                {
                    var options;
                    var chart;
                    if(flag)
                    {
                        //var data = filldata();
                        options = {
                            title: 'Fresh Market Mondays!',
                            chartArea: {width: '50%'},
                            hAxis: {
                                title: 'Total Resources',
                                minValue: 0,
                                textStyle: {
                                    bold: true,
                                    fontSize: 12,
                                    color: '#4d4d4d'
                                },
                                titleTextStyle: {
                                    bold: true,
                                    fontSize: 18,
                                    color: '#4d4d4d'
                                }
                            },
                            vAxis: {
                                title: 'Months',
                                textStyle: {
                                    fontSize: 14,
                                    bold: true,
                                    color: '#848484'
                                },
                                titleTextStyle: {
                                    fontSize: 14,
                                    bold: true,
                                    color: '#848484'
                                }
                            }
                    };
                        chart = new google.visualization.BarChart(document.getElementById('main_chart'));
                        chart.draw(data, options);
                    }
                    else
                    {
                        options = {
                            chart: {
                            title: 'September Performance',
                            subtitle: 'Sales, Expenses, and Profit:',
                          }
                        };
                        chart = new google.charts.Bar(document.getElementById('chart_di'));
                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                }
                
                function changeChart(id)
                {
                    //fix this 
                    //----------------------------------------------------------
                    console.log(id);
                    if(id == 'First')
                    {
                        data.removeRow(0);
                        data.removeRow(0);
                        data.removeRow(0);
                        data.removeRow(0);
                        
                        data.addRow([one.months, one.m_donate, one.m_cost, one.m_employee]);
                        data.addRow([two.months, two.m_donate, two.m_cost, two.m_employee]);
                        data.addRow([two.months, two.m_donate, two.m_cost, two.m_employee]);
                        data.addRow([four.months, four.m_donate, four.m_cost, four.m_employee]);
                    }
                    else if(id == 'Second')
                    {
                        data.removeRow(0);
                        data.removeRow(0);
                        data.removeRow(0);
                        data.removeRow(0);
                        
                        data.addRow([five.months, five.m_donate, five.m_cost, five.m_employee]);
                        data.addRow([five.months, five.m_donate, five.m_cost, five.m_employee]);
                        data.addRow([five.months, five.m_donate, five.m_cost, five.m_employee]);
                        data.addRow([five.months, five.m_donate, five.m_cost, five.m_employee]);
                        console.log('here');
                    }
                    //------------------------------------------------------------------------------
                    drawChart(data, true);
                    //tableChart.draw(data);
                }
            </script>
        </footer>
    </body>
</html>