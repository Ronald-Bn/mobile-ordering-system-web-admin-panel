 <table border='0' style="width: 100%;">

     <tr>

         <th>Product</th>

         <th>Quantity</th>

         <th>Amount</th>

     </tr>

     <?php
        include('dbcon.php');

        $userid = $_POST['userid'];
        $ref_cart = '/Cart_List/' . $userid;
        $fetchdata = $database->getReference($ref_cart)->getSnapshot()->getValue();


        if ($fetchdata > 0) {
            $i = 0;
            $total_price = 0;
            $total_product = 0;
            foreach ($fetchdata as $key => $row) {
                $total_price +=  (int)$row['totalPrice'];
                $total_product += (int)$row['quantity'];
        ?>
             <tr>
                 <td style="display:none;"><?= $row['key']; ?></td>
                 <td><?= $row['name']; ?></td>
                 <td><?= $row['quantity']; ?></td>
                 <td><?= $row['totalPrice']; ?></td>
             </tr>

         <?php

            }
            print "
                            <td>Total Amount:</td>
                             <td>$total_product</td>
                            <td>$total_price</td>";
        } else {
            ?>
         <tr>
             <td colspan="7">No Record Found</td>
         </tr>

     <?php
        }
        ?>
 </table>