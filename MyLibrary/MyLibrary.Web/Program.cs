using Microsoft.EntityFrameworkCore;
using MyLibrary.Web.Data;
using MyLibrary.Web.Services.Abstractions;
using MyLibrary.Web.Services.Implementations;

WebApplicationBuilder builder = WebApplication.CreateBuilder(args);

builder.Services.AddControllersWithViews();

// Data Context
builder.Services.AddDbContext<DataContext>(config =>
{
    config.UseSqlServer(builder.Configuration.GetConnectionString("MyConnection"));
});

builder.Services.AddScoped<IAuthorsService, AuthorsService>();
builder.Services.AddScoped<IBooksService, BooksService>();

WebApplication app = builder.Build();

if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Home/Error");
    app.UseHsts();
}

app.UseHttpsRedirection();
app.UseRouting();

app.UseAuthorization();

app.MapStaticAssets();

app.MapControllerRoute(
    name: "default",
    pattern: "{controller=Home}/{action=Index}/{id?}")
    .WithStaticAssets();


app.Run();
