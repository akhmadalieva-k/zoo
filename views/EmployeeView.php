<?php
print_r($data);
?>

<h1>Страница сотрудника: </h1>
<br>
<a href="http://localhost:84/employees/all">Вернуться к списку всех сотрудников</a>
<?php
$titles = [
    "employee_id" => "номер",
    "employee_name" => "имя",
    "specialization_name" => "специализация",
    "department_name" => "отдел",
]; ?>

<table>
    <thead>
        <tr>
            <?php foreach ($titles as $titleKey => $titleValue): ?>
                <th>
                    <?php echo $titleValue; ?>
                </th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($data as $k => $val): ?>
                <td><?php if($k == "department_name")
                {
                    $department = htmlspecialchars($val);
                    echo "<a href='http://localhost:84/animals/$department'>$department</a>";
                }
                else {
                echo htmlspecialchars($val);
                }
                    ?>
                </td>

            <?php 
        endforeach; ?>
        </tr>
    </tbody>
</table>
    <h2>Редактировать сотрудника:</h2>
<form action="http://localhost:84/employee/save" method="post">
        <div class="form__input">
            <label for="employee_name">ФИО:</label>
            <input type="text" name="value[employee_name]" id="employee_name" value="<?= htmlspecialchars($data['employee_name']) ?>">
            <br>
            <label for="specialization_id">Специализация:</label>
                    <select name="value[specialization_id]" id="specialization_id">
                        <option value="1">зоология</option>
                        <option value="2">орнитология</option>
                        <option value="3">герпетология</option>
                        <option value="4">амфибиология</option>
                        <option value="5">ихтиология</option>
                        <option value="6">энтомология</option>
                    </select>
            <br>
            <label for="employee_id">Индивидуальный номер сотрудника:</label>
            <input type="number" name="value[employee_id]" id="employee_id" value="<?= htmlspecialchars($data['employee_id']) ?>" readonly>
            <input name="add_employee" type="submit" value="save">
        </div>
    </form>
    <h2>Удалить сотрудника из базы:</h2>
    <form action="http://localhost:84/employee/delete/<?=$data["animal_id"]?>" method="post">
        <div class="form__input">
        <label for="employee_id_to_delete">Индивидуальный номер сотрудника:</label>
        <input type="number" name="employee_id_to_delete" id="employee_id_to_delete" value="<?= htmlspecialchars($data['employee_id']) ?>" readonly>
        <br>
        <input name="delete_employee" type="submit" value="удалить">
        </div>
    </form>