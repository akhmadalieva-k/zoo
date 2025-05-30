<ul>
    <?php foreach($data as $key => $value) : ?>
    <li>
        <?php echo "<a href='http://localhost:84/$key'>$value</a>"; ?>
    </li>
    <?php endforeach; ?>
</ul>