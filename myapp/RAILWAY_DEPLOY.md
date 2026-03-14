# Deploy Laravel LMS to Railway

Step-by-step guide to deploy your LMS to Railway (free tier).

---

## Prerequisites

1. **GitHub account** – Railway deploys from GitHub
2. **Railway account** – Sign up at [railway.app](https://railway.app)
3. **Push your code** – Ensure your project is in a GitHub repository

---

## Step 1: Push to GitHub

If not already done, push your project to GitHub:

```bash
cd "E:\web Developement\lms\myapp"
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO.git
git push -u origin main
```

> **Note:** If your Laravel app is inside a subfolder (e.g. `lms/myapp`), you have two options:
> - **Option A:** Push only the `myapp` folder as the repo root
> - **Option B:** Push the whole `lms` folder and set **Root Directory** to `myapp` in Railway

---

## Step 2: Create Railway Project

1. Go to [railway.app/new](https://railway.app/new)
2. Click **Deploy from GitHub repo**
3. Select your repository
4. Railway will create a new project and start deploying

---

## Step 3: Add Database

1. In your Railway project, click **+ New**
2. Select **Database** → **MySQL** (or **PostgreSQL** if you prefer)
3. Railway will provision the database and provide connection variables

---

## Step 4: Configure Environment Variables

1. Click on your **Laravel app service** (not the database)
2. Go to **Variables** tab
3. Click **Raw Editor** and add these variables:

### Required Variables

| Variable | Value |
|----------|-------|
| `APP_NAME` | LMS |
| `APP_ENV` | production |
| `APP_DEBUG` | false |
| `APP_KEY` | *(run `php artisan key:generate --show` locally and paste)* |
| `APP_URL` | *(leave empty for now; set after generating domain)* |

### Database (choose one)

**If using MySQL:**
| Variable | Value |
|----------|-------|
| `DB_CONNECTION` | mysql |
| `DB_URL` | `${{MySQL.MYSQL_URL}}` |

**If using PostgreSQL:**
| Variable | Value |
|----------|-------|
| `DB_CONNECTION` | pgsql |
| `DB_URL` | `${{Postgres.DATABASE_URL}}` |

> Replace `MySQL` or `Postgres` with your actual database service name if different.

### Railway-specific (recommended)

| Variable | Value |
|----------|-------|
| `NIXPACKS_PHP_ROOT_DIR` | /app/public |
| `LOG_CHANNEL` | stderr |
| `SESSION_DRIVER` | database |
| `CACHE_STORE` | database |
| `QUEUE_CONNECTION` | database |

---

## Step 5: Build & Deploy Settings

1. Go to your app service **Settings**
2. Under **Build**:
   - **Custom Build Command:** `composer install --no-dev --optimize-autoloader && npm install && npm run build`
3. Under **Deploy**:
   - **Pre-Deploy Command:** `chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh`
4. Under **Source** (if your app is in a subfolder):
   - **Root Directory:** `myapp` *(only if repo root is `lms`)*

---

## Step 6: Generate Domain

1. Go to your app service **Settings**
2. Click **Networking** → **Generate Domain**
3. Copy the URL (e.g. `your-app.up.railway.app`)
4. Add to Variables: `APP_URL` = `https://your-app.up.railway.app`
5. Redeploy for the change to take effect

---

## Step 7: Deploy

1. Click **Deploy** (or push a new commit to trigger auto-deploy)
2. Wait for the build to complete
3. Visit your generated domain

---

## Troubleshooting

### Build fails
- Ensure **Root Directory** is set correctly if your Laravel app is in a subfolder
- Check that `package-lock.json` exists (run `npm install` locally first)

### Database connection error
- Verify `DB_URL` references the correct service: `${{YourDatabaseServiceName.DATABASE_URL}}` or `${{YourDatabaseServiceName.MYSQL_URL}}`
- Ensure both app and database are in the same Railway project

### 500 error after deploy
- Check **Deploy Logs** for errors
- Ensure migrations ran (Pre-Deploy Command)
- Verify `APP_KEY` is set

### Assets not loading
- Ensure `npm run build` runs during build
- Set `APP_URL` correctly (with `https://`)

---

## Free Tier Limits

- **$5 credit/month** – Usually enough for a small LMS
- **512MB RAM** – Sufficient for low traffic
- **Sleep** – Services may sleep after inactivity (wake on first request)

---

## Optional: Add Admin User After Deploy

Run a one-off command via Railway CLI:

```bash
railway run php artisan tinker
# Then: \App\Models\User::factory()->create(['email' => 'admin@example.com', 'role' => 'admin']);
```

Or use your seeders if you have them configured.
