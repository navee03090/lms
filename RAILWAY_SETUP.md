# ⚠️ Railway Setup Required

**If your build fails with "Railpack could not determine how to build the app"**, you must set the **Root Directory**.

## Fix: Set Root Directory

1. Go to your Railway project → **lms** service
2. Click **Settings** (gear icon)
3. Under **Source**, find **Root Directory**
4. Set it to: **`myapp`**
5. Click **Deploy** to redeploy

![Root Directory location: Settings → Source → Root Directory](https://docs.railway.com/builds/build-configuration#root-directory)

The Laravel app lives in the `myapp` folder. Without this setting, Railpack only sees the folder structure and cannot find `composer.json` or PHP files.

---

Full deployment guide: [myapp/RAILWAY_DEPLOY.md](myapp/RAILWAY_DEPLOY.md)
