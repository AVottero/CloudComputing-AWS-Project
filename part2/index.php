<!-- file name: index.php
final project 420-1nf-01, part 2
Author: Alyssa Vottero
Instructor: Lounis Zaidi
-->

<!DOCTYPE html>
<html>
    <head>
        <title>Instructor List</title>
        <style>
            table {
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid black;
                padding: 8px 15px;
                text-align: center;
            }

            th {
                background-color: lightgray;
            }
        </style>
    </head>
    <body>
        <h1>Instructor List</h1>
        <?php

        // DB credentials are written to this EC2 instance at boot, outside the
        // document root so they are never served over HTTP. They point at the
        // RDS endpoint - this instance runs no MySQL server of its own.
        $cfg = parse_ini_file('/etc/webapp/db.ini');
        $conn = new mysqli(
            $cfg['host'],
            $cfg['user'],
            $cfg['password'],
            $cfg['dbname'],
            (int) $cfg['port']
        );

        if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM instructors");

        if(!$result)
            {
            die("Query failed: " . $conn->error);
        }

        ?>
        <table>
            <tr text-align="center">
                <th>Instructor Code</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>

            <?php
            while($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row["InstructorCode"]; ?></td>
                    <td><?php echo $row["InstructorFirstname"]; ?></td>
                    <td><?php echo $row["InstructorLastname"]; ?></td>                   
                </tr>
            <?php
            }
            ?>
        </table>
        <?php
        $conn->close();
        ?>
    </body>
</html>