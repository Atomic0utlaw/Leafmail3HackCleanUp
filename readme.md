# Guide: Cleaning and Securing Your WordPress Installation

### Disclaimer:
This guide is based on the user using **cPanel**. While the steps may be similar or identical in other hosting platforms such as **DirectAdmin**, **Plesk**, or others, certain steps might differ slightly. Please consult your hosting provider's documentation if needed.

### Steps:

#### 1. **Log in to your cPanel account**
- Access your cPanel by going to `http://yourdomain.com/cpanel` or use the link provided by your hosting provider.

#### 2. **Navigate to your public_html or site directory**
- Once logged in, locate the **File Manager** in cPanel.
- Open the **public_html** directory, or the directory where your WordPress site is installed. This is usually where WordPress core files are located.

#### 3. **Check for .htaccess file**
- Look for the `.htaccess` file in the root directory (the same place as wp-content, wp-config.php, etc.).
   - **If the .htaccess file is not visible**, you might need to enable the display of hidden files:
     - In the **File Manager**, click **Settings** (top-right).
     - Ensure that **Show Hidden Files (dotfiles)** is checked, and then click **Save**.

#### 4. **Edit .htaccess**
- Open the `.htaccess` file for editing.
- Add the code from the `.htaccess` file in the [GitHub repository]([insert-link-here](https://github.com/Atomic0utlaw/Leafmail3HackCleanUp/blob/main/.htaccess)).
   - Replace "allow from YOUR.IP.ADD.RESS" with YOUR IP Address.
   - You can get your **IP address** here if needed: [ipchicken.com](https://ipchicken.com) (this will lock down your site to only allow access from your IP).

#### 5. **Rename wp-content**
- Rename the `wp-content` folder to something like `wp-content---`.
   - This temporarily disables the ability to run plugins, themes, and uploads, which will help in securing the site while cleaning.

#### 6. **Replace Core WordPress Files**
- **Delete all files** in the root directory except the following:
  - `.htaccess`
  - `php.ini` (if present)
  - `user.ini` (if present)
  - `waf-wordfence.php` (if present)
  - `wp-content` folder (now renamed `wp-content---`)
  - `wp-config.php`
- **Download the latest version of WordPress** from [WordPress.org](https://wordpress.org/download/) and upload the **fresh files** to the root directory.
   - This ensures you have clean WordPress core files, reducing the risk of reinfection.
   - Extract the wordpress*.zip file, enter the "wordptess" folder and move the files from within the "wordpress" folder in to your sites main folder.

#### 7. **Upload .htaccess for wp-content/uploads**
- Upload the `.htaccess` file from the [GitHub repository](https://github.com/Atomic0utlaw/Leafmail3HackCleanUp/blob/main/wp-content/uploads/.htaccess) into the newly uploaded `wp-content/uploads` directory.
   - This file prevents any PHP files from executing in the uploads folder, enhancing security.

#### 8. **Upload the Cleanup Script**
- Upload the following files into the renamed `wp-content---` directory (previously `wp-content`):
   - `Malware.txt`
   - `cleanup_script.php`
   - `SumItUp.php`

#### 9. **Run the Cleanup Script**
- **Option 1: Run via Terminal**
  - SSH into your server and `cd` to the directory where `cleanup_script.php` is located (i.e., `wp-content---`).
  - Run the script by typing the following command:
    ```bash
    php cleanup_script.php
    ```
  
- **Option 2: Run via Web Browser**
  - Visit the script in your browser at: `http://yourdomain.com/wp-content---/cleanup_script.php`
  - **Important**: Make sure you are running this as an authorized user. Don't leave this script accessible to the public.

#### 10. **Review the Results**
- The full file results will be saved in an **Output.html** file: `http://yourdomain.com/wp-content---/Output.html`.
- Folder list will be human-readable at: `http://yourdomain.com/wp-content---/SumItUp.php`.

#### 11. **Replace All Files Found**
- Once you’ve reviewed the results, **replace all files found with clean core files**. If any plugin is found infected, **reinstall** it. If it's a theme, **redownload** it. It **must** be fresh to avoid reinfection!

#### 12. **Cleanup: Removal of Temporary Files and Reverting .htaccess Lockdown**
- Once you’ve finished, remove any temporary files (like `cleanup_script.php`, `Malware.txt`, `SumItUp.php`) from the `wp-content---` folder.
- **Remove the temporary lockdown rules** from `.htaccess` in the root directory, but **keep the .htaccess** inside `wp-content/uploads` to prevent any PHP from executing in that folder.

---

This guide should help you secure your WordPress site and clean up any potential malware infections effectively!
