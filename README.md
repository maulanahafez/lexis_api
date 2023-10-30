# Installation Guide

To get this project up and running on your local machine, follow these steps:

1. **Clone the GitHub Repository:**

```bash
  git clone https://github.com/maulanahafez/lexis_api.git
```

2. **Navigate to the Project Directory**

```bash
  cd lexis_api
```

3. **Open in VSCode**

```bash
  code .
```

4. **Install Depedencies**

```bash
  composer install
```

5. **Create .env File or Copy Paste .env.example to .env**
   Configure it with the appropriate settings, such as database connection details, application key, and other environment-specific variables.
   <br>
6. **Generate Application Key**

```bash
  php artisan key:generate
```

7. **Migrate and Seed Database**

```bash
  php artisan migrate:fresh --seed
```

8. **Running App**

```bash
  php artisan ser
```
