# Nutanix Prism Central Category Management Demo

This small demo will create a collection of Prism Central category keys and values that are provided by accompanying JSON file.

## Usage

- Install [PHP composer](https://getcomposer.org/)
- Install the script dependencies:

  ```
  composer install
  ```

- Rename `.env.example` to `.env`
- Edit `.env` to match your environment requirements i.e. Prism Central IP address & credentials
- Edit `categories.json` to match the category keys and values you want to create
- Run the script:

  ```
  php ./categories.php
  ```

## Additional Info

This script does not require a verified SSL connection to Prism Central.  If you have configured Prism Central with a valid SSL certificate and require SSL certificate verification in your environment, please change all occurrences of this:

```
'verify' => false,
```

to this:

```
'verify' => true,
```

## Screenshot

All going well, the script's output will be similar to this:

![Screenshot of PHP category management script being run](./screenshot.png?raw=true)

## Disclaimer

Please see the `.disclaimer` file that is distributed with this repository.