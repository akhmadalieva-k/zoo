<?php
// foreach ($data as $key => $value) {
//     print_r($key);
//     echo " - ";
//     print_r($value);
//     echo "\n";
// }
?>

<!-- <div class="container__table"> -->
<h1>Страница животного: </h1>
<br>
<a href="http://localhost:84/animals/all">Вернуться к списку всех животных</a>
<?php
$titles = [
    "animal_id" => "номер",
    "species_lat" => "видовое название лат.",
    "species_rus" => "видовое название рус.",
    "animal_name" => "имя",
    "animal_class" => "класс",
    "sex" => "пол",
    "birth_date" => "дата рождения",
    "age" => "возраст, лет",
    "arrival_date" => "дата поступления на содержание",
    "color" => "цвет",
    "state" => "охранный статус",
    "animal_description" => "описание",
    "department_name" => "отдел"
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
<h2>Редактировать животное:</h2>
<form action="http://localhost:84/animal/save" method="post">
        <div class="form__input">
            <label for="species_lat">Видовое название на латыни:</label>
            <input type="text" name="value[species_lat]" id="species_lat" value="<?= htmlspecialchars($data['species_lat']) ?>">
            <br>
            <label for="species_rus">Видовое название на русском:</label>
            <input type="text" name="value[species_rus]" id="species_rus" value="<?= htmlspecialchars($data['species_rus']) ?>">
            <br>
            <label for="animal_name">Имя животного (до 100 символов):</label>
            <input type="text" name="value[animal_name]" id="animal_name" value="<?= htmlspecialchars($data['animal_name']) ?>">
            <br>
            <label for="class_id">Класс животного:</label>
            <select name="value[class_id]" id="class_id">
                <option value="1">рыбы</option>
                <option value="2">земноводные</option>
                <option value="3">рептилии</option>
                <option value="4">насекомые</option>
                <option value="5">птицы</option>
                <option value="6">млекопитающие</option>
            </select>
            <br>
            <label for="sex">Пол животного:</label>
            <select name="value[sex]" id="sex">
                <option value="м">мужской</option>
                <option value="ж">женский</option>
            </select>
            <br>
            <label for="birth_date">Дата рождения:</label>
            <input type="date" name="value[birth_date]" id="birth_date" value="<?= htmlspecialchars($data['birth_date'] ?? '') ?>">
            <br>
            <label for="arrival_date">Дата прибытия в зоопарк:</label>
            <input type="date" name="value[arrival_date]" id="arrival_date" value="<?= htmlspecialchars($data['arrival_date'] ?? '') ?>">
            <br>
            <label for="color">Цвет животного:</label>
            <input type="text" name="value[color]" id="color" value="<?= htmlspecialchars($data['color']) ?>">
            <br>
            <label for="conservation_status_id">Охранный статус:</label>
            <select name="value[conservation_status_id]" id="conservation_status_id">
                <option value="1">Исчезнувший в дикой природе</option>
                <option value="2">Находится на грани исчезновения</option>
                <option value="3">Уязвимый</option>
                <option value="4">Не имеет охранного статуса</option>
            </select>
            <br>
            <label for="animal_description">Краткое описание животного:</label>
            <input type="text" name="value[animal_description]" id="animal_description" value="<?= htmlspecialchars($data['animal_description']) ?>">
            <br>
            <label for="animal_id">Индивидуальный номер животного:</label>
            <input type="number" name="value[animal_id]" id="animal_id" value="<?= htmlspecialchars($data['animal_id']) ?>" readonly>
            <br>
            <input name="add_animal" type="submit" value="save">
        </div>
    </form>
    <h2>Удалить животное из базы:</h2>
    <form action="http://localhost:84/animal/delete/<?=$data["animal_id"]?>" method="post">
        <div class="form__input">
        <label for="animal_id_to_delete">Индивидуальный номер животного:</label>
        <input type="animal_id_to_delete" name="animal_id_to_delete" id="animal_id_to_delete" value="<?= htmlspecialchars($data['animal_id']) ?>" readonly>
        <br>
        <input name="delete_animal" type="submit" value="delete">
        </div>
    </form>
<!-- </div> -->


