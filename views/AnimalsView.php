<p><a href="http://localhost:84">На главную</a></p>
<div class="container__main">
    <div class="container__header">
        <h1>zoopark</h1>

    </div>
    <div class="container__body">
        <div class="container__table">
            <div class="container__table__head">
                <div class="container__table__options">
                    <h1>Список всех животных зооопарка 🐾</h1>
                    <div class="container__select__class">
                        <form action="http://localhost:84/animals/list" method="get">
                            <div class="checkbox">
                                <label for="class_id">выбрать класс:</label>
                                <select name="class" id="class_id">
                                    <option value="0">показать все</option>
                                    <option value="1">только рыбы</option>
                                    <option value="2">только земноводные</option>
                                    <option value="3">только рептилии</option>
                                    <option value="4">только насекомые</option>
                                    <option value="5">только птицы</option>
                                    <option value="6">только млекопитающие</option>
                                </select>
                                <input name="get_selected_animals" type="submit" value="показать">
                            </div>
                        </form>
                    </div>
                </div>
                <button onclick="openAddModal()">➕ Добавить животное</button>
            </div>
            <?php
            $titles = [
                "animal_id" => "номер",
                "species_lat" => "видовое название лат.",
                "species_rus" => "видовое название рус.",
                "animal_name" => "имя",
                "animal_class" => "класс",
                "sex" => "пол",
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
                    <?php foreach ($data["animals"] as $keyArr => $valueArr): ?>
                        <tr>
                            <?php foreach ($valueArr as $key => $cell): ?>
                                <?php if ($key == "animal_id"): ?>
                                    <td>
                                        <?php $id = htmlspecialchars($cell) ?>
                                        <button onclick='openEditModal(<?= json_encode($valueArr, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                            ✏ <?= htmlspecialchars($cell) ?>
                                        </button>
                                    </td>
                                <?php elseif ($key == "animal_name"): ?>
                                    <td>
                                        <?php $name = htmlspecialchars($cell); ?>
                                    <?php echo "<a href='http://localhost:84/animals/animalPage/$id'>$name</a>" ?>
                                    </td>
                                <?php elseif ($key == "class_id" || $key == "birth_date" || $key == "conservation_status_id"):
                                    continue; ?>
                                <?php elseif ($key == "department_id"): 
                                    $depRef = htmlspecialchars($cell  ?? '');
                                    continue; ?>
                                <?php elseif ($key == "department_name"): ?>
                                    <?php
                                        $dep = htmlspecialchars($cell  ?? '');?>
                                        <td>
                                        <?php echo "<a href='http://localhost:84/departments/department/$depRef'>$dep</a>"; ?>
                                        </td>
                                <?php else: ?>
                                    <td>
                                        <?php echo htmlspecialchars($cell ?? ''); ?>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Модальное окно добавления животного -->
<div id="addModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeAddModal()">&times;</span>
        <h2>добавить новое животное:</h2>
        <form action="http://localhost:84/animals/add" method="post">
            <div class="form__input">
                <label for="species_lat">Видовое название на латыни:</label>
                <input type="text" name="value[species_lat]" id="species_lat" required placeholder="Введите видовое название">
                <br>
                <label for="species_rus">Видовое название на русском:</label>
                <input type="text" name="value[species_rus]" id="species_rus" required placeholder="Введите видовое название">
                <br>
                <label for="animal_name">Имя животного (до 100 символов):</label>
                <input type="text" name="value[animal_name]" id="animal_name">
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
                <input type="date" name="value[birth_date]" id="birth_date" required placeholder="Введите дату рождения">
                <br>
                <label for="arrival_date">Дата прибытия в зоопарк:</label>
                <input type="date" name="value[arrival_date]" id="arrival_date">
                <br>
                <label for="color">Цвет животного:</label>
                <input type="text" name="value[color]" id="color">
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
                <input type="text" name="value[animal_description]" id="animal_description">
                <br>
                <label for="department_id">Отдел:</label>
                <select name="value[department_id]" id="department_id" required>
                <?php foreach ($data["departments"] as $emp): ?>
                    <option value="<?= htmlspecialchars($emp['department_id']) ?>">
                        <?= htmlspecialchars($emp['department_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
                <br>
                <input name="add_animal" type="submit" value="add_animal">
            </div>
        </form>
    </div>
</div>

<!-- Модальное окно редактирования животного -->
<div id="editModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Редактировать животное</h2>
        <form id="editForm" method="post" action="http://localhost:84/animals/update">
            <input type="hidden" name="value[animal_id]" id="edit_animal_id">

            <label for="edit_species_lat">Видовое название на латыни:</label>
            <input type="text" name="value[species_lat]" id="edit_species_lat"><br>

            <label for="edit_species_rus">Видовое название на русском:</label>
            <input type="text" name="value[species_rus]" id="edit_species_rus"><br>

            <label for="edit_animal_name">Имя животного:</label>
            <input type="text" name="value[animal_name]" id="edit_animal_name"><br>

            <label for="edit_class_id">Класс животного:</label>
            <select name="value[class_id]" id="edit_class_id">
                <option value="1">рыбы</option>
                <option value="2">земноводные</option>
                <option value="3">рептилии</option>
                <option value="4">насекомые</option>
                <option value="5">птицы</option>
                <option value="6">млекопитающие</option>
            </select><br>

            <label for="edit_sex">Пол:</label>
            <select name="value[sex]" id="edit_sex">
                <option value="м">м</option>
                <option value="ж">ж</option>
            </select><br>

            <label for="edit_birth_date">Дата рождения:</label>
            <input type="date" name="value[birth_date]" id="edit_birth_date"><br>

            <label for="edit_arrival_date">Дата прибытия:</label>
            <input type="date" name="value[arrival_date]" id="edit_arrival_date"><br>

            <label for="edit_color">Цвет:</label>
            <input type="text" name="value[color]" id="edit_color"><br>

            <label for="edit_conservation_status_id">Охранный статус:</label>
            <select name="value[conservation_status_id]" id="edit_conservation_status_id">
                <option value="1">Исчезнувший в дикой природе</option>
                <option value="2">На грани исчезновения</option>
                <option value="3">Уязвимый</option>
                <option value="4">Без статуса</option>
            </select><br>

            <label for="edit_animal_description">Описание:</label>
            <input type="text" name="value[animal_description]" id="edit_animal_description"><br>
            <label for="edit_department_id">Отдел:</label>
                <select name="value[department_id]" id="edit_department_id" required>
                <?php foreach ($data["departments"] as $emp): ?>
                    <option value="<?= htmlspecialchars($emp['department_id']) ?>">
                        <?= htmlspecialchars($emp['department_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Сохранить изменения">
        </form>
        <h2>Удалить животное из базы:</h2>
        <form action="http://localhost:84/animals/delete" method="post">
            <div class="form__input">
                <input type="hidden" name="animal_id" id="delete_animal_id">
              <br>
                <input name="delete_animal" type="submit" value="delete">
            </div>
        </form>
    </div>
</div>
<script>
    function formatDate() {
        let date = new Date();
        let day = String(date.getDate()).padStart(2, '0');
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let year = date.getFullYear();

        return `${year}-${month}-${day}`;
    }
    document.querySelector('#arrival_date').value = formatDate();

    const modal = document.getElementById("editModal");
    const closeBtn = document.querySelector(".close-button");

    closeBtn.onclick = () => {
        modal.style.display = "none";
    };

    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    function openEditModal(animal) {
        // Заполнение формы
        document.getElementById("edit_animal_id").value = animal.animal_id;
        document.getElementById("edit_species_lat").value = animal.species_lat;
        document.getElementById("edit_species_rus").value = animal.species_rus;
        document.getElementById("edit_animal_name").value = animal.animal_name;
        document.getElementById("edit_class_id").value = animal.class_id;
        document.getElementById("edit_sex").value = animal.sex;
        document.getElementById("edit_birth_date").value = animal.birth_date;
        document.getElementById("edit_arrival_date").value = animal.arrival_date;
        document.getElementById("edit_color").value = animal.color;
        document.getElementById("edit_conservation_status_id").value = animal.conservation_status_id;
        document.getElementById("edit_animal_description").value = animal.animal_description;
        document.getElementById("edit_department_id").value = animal.department_id;

        document.getElementById("delete_animal_id").value = animal.animal_id;

        modal.style.display = "flex";
    }

    function openAddModal() {
        document.getElementById("addModal").style.display = "block";
    }

    function closeAddModal() {
        document.getElementById("addModal").style.display = "none";
    }

    // Закрытие при клике вне окна
    window.onclick = function(event) {
        const modal = document.getElementById("addModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>