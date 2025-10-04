# Xdebug налаштування для Laravel Sail

## ✅ Налаштовано

Xdebug вже налаштований та готовий до використання:

### Конфігурація:
- **Port:** 9003
- **Mode:** develop,debug  
- **Client:** host.docker.internal
- **Path mapping:** `/var/www/html` → `${workspaceFolder}`

## 🎯 Як використовувати

### 1. Запуск дебагера в VS Code:
1. Перейдіть до Debug панелі (Ctrl+Shift+D)
2. Виберіть конфігурацію "Listen for Xdebug"
3. Натисніть F5 або кнопку ▶️

### 2. Встановлення breakpoints:
1. Відкрийте PHP файл (наприклад, `PostController.php`)
2. Клікніть ліворуч від номера рядка (з'явиться червона крапка)
3. Breakpoint встановлений!

### 3. Тестування:
1. Запустіть дебагер в VS Code
2. Відкрийте http://localhost у браузері  
3. Дебагер зупиниться на breakpoint в `PostController::home()`

## 🔧 Команди

```bash
# Перезапуск Sail з Xdebug
sail down && sail up -d

# Перевірка Xdebug
sail exec laravel.test php -m | grep xdebug

# Перевірка конфігурації  
sail exec laravel.test php -i | grep xdebug.mode
```

## 📁 Файли конфігурації

- `.env` - змінні SAIL_XDEBUG_MODE і SAIL_XDEBUG_CONFIG
- `.vscode/launch.json` - конфігурація VS Code debugger
- `.vscode/settings.json` - налаштування PHP Intelephense

## 🐛 Troubleshooting

Якщо дебагер не підключається:

1. Перевірте, що порт 9003 не зайнятий іншими процесами
2. Переконайтеся, що VS Code слухає на правильному порті
3. Перезапустіть Sail: `sail down && sail up -d`
4. Перезапустіть VS Code

## 🎉 Готово!

Xdebug налаштований та готовий до використання. Приємного дебагінгу! 🚀