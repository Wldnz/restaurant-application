<?php




function createTable($columnField, $rowField, $sql, $mysql)
{
?>
    <table class="table-laporan">
        <tr>
            <?php
            foreach ($columnField as $key => $field) {

                if ($key != "action_name" && $key != "Action" && $key != 'isMany') {
            ?>
                    <th><?= $field ?></th>
                <?php } elseif ($key != 'action_name' && $key != 'isMany') {
                ?>
                    <th><?= $key ?></th>
            <?php }
            } ?>
        </tr>
        <?php $result = $mysql->query($sql);
        while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <?php foreach ($rowField as $key => $field) { ?>
                    <td><?= $row[$field] ?></td>
                    <?php if (count($rowField) == ($key + 1) && isset($columnField['Action'])) {
                        if (isset($columnField['isMany']) && $columnField['isMany']) { ?>
                            <td>
                                <form action="<?= $columnField['Action'] ?>" method="GET">
                                    <button type="submit" class="btn" name="detailPesanan" value="<?= $row['id'] ?>"><?= $columnField['action_name'] ?></button>
                                </form>
                            </td>
                        <?php } elseif (isset($columnField['isMany']) && !$columnField['isMany']) { ?>
                            <td>
                                <form action="<?= $columnField['Action'] ?>" method="GET">
                                    <button type="submit" class="btn" name="detailPesanan" value="<?= $row['id'] ?>"><?= $columnField['action_name'] ?></button>
                                </form>
                            </td>
            <?php return;
                        }
                    }
                }
            } ?>
            </tr>
    </table>
<?php }
?>