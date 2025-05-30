<?php
// print_r($data);
?>
<div class="container__main">
    <div class="container__header">
        <h1>zoopark</h1>
    </div>
    <div class="container__body">
        <div class="container__options">
            <h2>выбрать параметры:</h2>
            <form action="http://localhost:84/employees/select" method="post">
                <div class="checkbox">
                    <label for="spec_id">вабрать специализацию:</label>
                    <select name="spec_id" id="spec_id">
                        <option value="all">показать все</option>
                        <option value="1">зоология</option>
                        <option value="2">орнитология</option>
                        <option value="3">герпетология</option>
                        <option value="4">амфибиология</option>
                        <option value="5">ихтиология</option>
                        <option value="6">энтомология</option>
                    </select>
                    <input name="get_selected_spec" type="submit" value="показать">
                </div>
            </form>
            <br>
            <h2>добавить нового сотрудника:</h2>
            <form action="http://localhost:84/employees/add" method="post">
                <div class="form__input">
                    <label for="employee_name">ФИО:</label>
                    <input type="text" name="value[employee_name]" id="employee_name">
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
                    <input name="add_employee" type="submit" value="добавить">
                </div>
            </form>
        </div>
        <div class="container__table">
            <h1>Список всех сотрудников зооопарка 🐾</h1>
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
                    <?php foreach ($data as $keyArr => $valueArr): ?>
                        <tr>
                            <?php //foreach ($valueArr as $key => $cell): 
                            for ($i = 0; $i < count($valueArr); $i++):
                            ?>
                                <td><?php if ($i == 0) {
                                        $id = htmlspecialchars($valueArr[$i]);
                                        echo "<a href='http://localhost:84/employee/redact/$id'>$id</a>";
                                    }
                                    else if ($i == 3) {
                                        $idDep = htmlspecialchars($valueArr[$i]);
                                        echo "<a href='http://localhost:84/animal/redact/$idDep'>$idDep</a>";
                                    } else {
                                        echo htmlspecialchars($valueArr[$i]); // htmlspecialchars($cell); 
                                    };
                                    ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>