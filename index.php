<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица умножения</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php
        // Определяем текущие параметры
        // По умолчанию - табличная верстка (если не указано иное)
        $html_type = isset($_GET['html_type']) ? $_GET['html_type'] : 'TABLE';
        $content = isset($_GET['content']) ? $_GET['content'] : null;

        // Определяем, была ли первая загрузка (нет параметра html_type)
        $is_first_load = !isset($_GET['html_type']);
        ?>
        
        <!-- Шапка с главным меню -->
        <header>
            <nav class="main-menu">
                <a href="?html_type=TABLE<?php echo $content ? '&content=' . $content : ''; ?>"
                class="<?php echo (!$is_first_load && $html_type == 'TABLE') ? 'selected' : ''; ?>">
                    Табличная верстка
                </a>
                <a href="?html_type=DIV<?php echo $content ? '&content=' . $content : ''; ?>"
                class="<?php echo (!$is_first_load && $html_type == 'DIV') ? 'selected' : ''; ?>">
                    Блочная верстка
                </a>
            </nav>
        </header>
        
        <!-- Боковое меню -->
        <aside>
            <nav class="side-menu">
                <a href="?html_type=<?php echo $html_type; ?>"
                   class="<?php echo !isset($_GET['content']) ? 'selected' : ''; ?>">
                    Всё
                </a>
                <?php for($i = 2; $i <= 9; $i++): ?>
                    <a href="?html_type=<?php echo $html_type; ?>&content=<?php echo $i; ?>"
                       class="<?php echo (isset($_GET['content']) && $content == $i) ? 'selected' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </nav>
        </aside>
        
        <!-- Основной контент -->
        <main>
            <h1>Таблица умножения <?php echo $content != null ? 'на ' . $content : ''; ?></h1>
            
            <?php
            // Функция для преобразования числа в ссылку
            function numberToLink($num) {
                if ($num >= 1 && $num <= 9) {
                    // Ссылки на числа сбрасывают тип верстки (не передают html_type)
                    return '<a href="?content=' . $num . '">' . $num . '</a>';
                }
                return (string)$num;
            }
            
            // Функция для вывода строки таблицы умножения
            function printRow($n) {
                for($i = 1; $i <= 10; $i++) {
                    $result = $n * $i;
                    echo '<div class="block-row">';
                    echo numberToLink($n) . ' × ' . numberToLink($i) . ' = ' . numberToLink($result) . '<br>';
                    echo '</div>';
                }
            }
            
            // Вывод таблицы умножения
            if(!isset($_GET['html_type']) || $html_type == 'TABLE') {
                // Табличная верстка
                echo '<div class="table-container">';
                
                if(!isset($_GET['content'])) {
                    // Вся таблица умножения (от 2 до 9)
                    echo '<table>';
                    echo '<tr><th>×</th>';
                    for($i = 1; $i <= 10; $i++) {
                        echo '<th>' . numberToLink($i) . '</th>';
                    }
                    echo '</tr>';
                    
                    for($i = 1; $i <= 10; $i++) {
                        echo '<tr>';
                        echo '<td><strong>' . numberToLink($i) . '</strong></td>';
                        for($j = 1; $j <= 10; $j++) {
                            $result = $i * $j;
                            echo '<td>' . numberToLink($result) . '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    // Один столбец - таблица умножения на конкретное число
                    echo '<table>';
                    echo '<tr><th>×</th>';
                    for($i = 1; $i <= 10; $i++) {
                        echo '<th>' . numberToLink($i) . '</th>';
                    }
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td cosplan="11"><strong>' . numberToLink($content) . '</strong></td>';
                    for($i = 1; $i <= 10; $i++) {
                        $result = $content * $i;
                        echo '<td>' . numberToLink($result) . '</td>';
                    }
                    echo '</table>';
                }
                
                echo '</div>';
                
            } else {
                // Блочная верстка
                echo '<div class="blocks-container">';
                
                if(!isset($_GET['content'])) {
                    // Вся таблица умножения (от 1 до 10)
                    for($i = 1; $i <= 10; $i++) {
                        echo '<div class="multi-block">';
                        printRow($i);
                        echo '</div>';
                        }
                    echo '</div>';
                } else {
                    // Один столбец - таблица умножения на конкретное число
                    echo '<div class="single-block">';
                    printRow($content);
                    echo '</div>';
                }
                
                echo '</div>';
            }
            ?>
        </main>
        
        <!-- Подвал с информацией -->
        <footer>
            <div class="info">
                <?php
                $info = '';
                
                // Тип верстки
                if(!isset($_GET['html_type']) || $html_type == 'TABLE') {
                    $info .= 'Табличная верстка. ';
                } else {
                    $info .= 'Блочная верстка. ';
                }
                
                // Название таблицы
                if(!isset($_GET['content'])) {
                    $info .= 'Таблица умножения полностью. ';
                } else {
                    $info .= 'Таблица умножения на ' . $content . '. ';
                }
                
                // Дата и время
                date_default_timezone_set('Europe/Moscow');
                $info .= date('d.m.Y H:i:s');
                
                echo $info;
                ?>
            </div>
        </footer>
    </div>
</body>
</html>