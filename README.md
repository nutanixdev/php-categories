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

This script is provided as a quick demonstration **only**.  It is not written to represent any level of production-ready code and will require extensive modification before any code is used in a production environment.

While you are welcome to take and modify anything you like from this demo script, please make sure you add appropriate exception handling and error-checking before running it in a production environment.
