<style>
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7fb; margin: 0; color: #1f2937; }
    .rbac-topbar { background: #111827; color: #fff; padding: 16px 28px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; }
    .rbac-topbar a { color: #cbd5e1; text-decoration: none; margin-left: 14px; font-size: 14px; }
    .rbac-topbar a:hover { color: #fff; }
    .rbac-wrap { max-width: 1180px; margin: 28px auto; padding: 0 18px; }
    .rbac-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; flex-wrap: wrap; margin-bottom: 20px; }
    .rbac-title h1 { margin: 0 0 8px; font-size: 28px; }
    .rbac-title p { margin: 0; color: #64748b; }
    .rbac-actions { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
    .rbac-btn { display: inline-flex; align-items: center; gap: 8px; border: 0; border-radius: 8px; padding: 10px 14px; text-decoration: none; font-weight: 700; cursor: pointer; font-size: 14px; }
    .rbac-btn.primary { background: #2563eb; color: #fff; }
    .rbac-btn.secondary { background: #e2e8f0; color: #0f172a; }
    .rbac-btn.danger { background: #dc2626; color: #fff; }
    .rbac-btn.success { background: #16a34a; color: #fff; }
    .rbac-search { display: flex; gap: 8px; background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 8px; }
    .rbac-search input { border: 0; outline: 0; min-width: 240px; font-size: 14px; }
    .rbac-panel { background: #fff; border-radius: 10px; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08); overflow: hidden; border: 1px solid #e5e7eb; }
    .rbac-table { width: 100%; border-collapse: collapse; }
    .rbac-table th { background: #1f2937; color: #f8fafc; padding: 14px; text-align: left; font-size: 12px; text-transform: uppercase; }
    .rbac-table td { padding: 14px; border-bottom: 1px solid #eef2f7; vertical-align: middle; }
    .rbac-table tr:hover td { background: #f8fafc; }
    .rbac-badge { display: inline-block; padding: 4px 9px; border-radius: 999px; background: #eff6ff; color: #1d4ed8; font-weight: 700; font-size: 12px; }
    .rbac-alert { padding: 12px 14px; border-radius: 8px; margin-bottom: 16px; font-weight: 700; }
    .rbac-alert.ok { background: #dcfce7; color: #166534; }
    .rbac-alert.err { background: #fee2e2; color: #991b1b; }
    .rbac-form { display: grid; gap: 16px; padding: 22px; }
    .rbac-form label { display: block; font-weight: 700; margin-bottom: 6px; color: #334155; }
    .rbac-form input, .rbac-form textarea { width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font: inherit; }
    .rbac-form textarea { min-height: 100px; resize: vertical; }
    .rbac-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px; padding: 18px; }
    .rbac-check { border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; background: #fff; display: flex; gap: 10px; align-items: flex-start; }
    .rbac-check small { display: block; color: #64748b; margin-top: 3px; }
    .rbac-matrix { overflow-x: auto; }
    .rbac-matrix th, .rbac-matrix td { white-space: nowrap; text-align: center; }
    .rbac-matrix th:first-child, .rbac-matrix td:first-child { text-align: left; position: sticky; left: 0; background: inherit; }
    @media (max-width: 680px) { .rbac-search input { min-width: 120px; } .rbac-table { font-size: 13px; } .rbac-table th, .rbac-table td { padding: 10px; } }
</style>
