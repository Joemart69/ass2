# SkillSwap – Assessment 2

**Student:** Joemart Xuereb (s3843976)

## Project URL
- Titan deployment: https://titan.csit.rmit.edu.au/~s3843976/wp/a2

## Run Locally
1. Start Apache + MySQL in XAMPP.
2. Create database `skillswap` and import the `skills` table (SQL schema provided or add rows via the Add Skill form).
3. Place the `a2` folder into `C:\xampp\htdocs\a2`.
4. Open [http://localhost/a2/index.php](http://localhost/a2/index.php) in your browser.

## Project Structure
- `index.php`: Homepage with featured skills.
- `allskills.php`: List view of all skills in table format.
- `gallery.php`: Image gallery with modal preview.
- `addskill.php`: Form to add new skills to the database.
- `details.php`: Skill detail page.
- `includes/`: Header, navigation, footer, DB connection.
- `assets/css/`: Stylesheets.
- `assets/js/`: Scripts (gallery modal, validation).
- `assets/images/`: Logos, banners, skill images.
