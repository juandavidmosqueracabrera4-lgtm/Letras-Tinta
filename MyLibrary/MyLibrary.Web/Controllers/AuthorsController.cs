using Microsoft.AspNetCore.Mvc;
using MyLibrary.Web.Data.Entities;
using MyLibrary.Web.DTOs;
using MyLibrary.Web.Services.Abstractions;

namespace MyLibrary.Web.Controllers
{
    public class AuthorsController : Controller
    {
        private readonly IAuthorsService _authorsService;

        public AuthorsController(IAuthorsService authorsService)
        {
            _authorsService = authorsService;
        }

        [HttpGet]
        public async Task<IActionResult> Index()
        {
            List<Author> list = await _authorsService.GetListAsync();
            return View(list);
        }

        [HttpGet]
        public IActionResult Create()
        {
            return View();
        }

        [HttpPost]
        public async Task<IActionResult> Create(CreateAuthorDTO dto)
        {
            if (!ModelState.IsValid)
            {
                return View(dto);
            }

            await _authorsService.CreateAsync(dto);

            return RedirectToAction(nameof(Index));
        }

        [HttpGet]
        public async Task<IActionResult> GetOne([FromRoute] Guid id)
        {
            UpdateAuthorDTO dto = await _authorsService.GetOneAsync(id);

            return View("Update", dto);
        }

        [HttpPost]
        public async Task<IActionResult> Update([FromForm] UpdateAuthorDTO dto)
        {
            if (!ModelState.IsValid)
            {
                return View(dto);
            }

            await _authorsService.UpdateAsync(dto);

            return RedirectToAction(nameof(Index));
        }

        [HttpPost]
        public async Task<IActionResult> Delete([FromRoute] Guid id)
        {
            await _authorsService.DeleteAsync(id);

            return RedirectToAction(nameof(Index));
        }

        //[FromRoute] ->  www.url.com/12
        //[FromForm] -> form html
        //[FromBody] -> json -> { "id" : 12 }
        //[FromQuery] -> www.url.com?id=12
    }
}
