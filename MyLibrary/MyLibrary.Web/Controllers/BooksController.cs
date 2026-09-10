using Microsoft.AspNetCore.Mvc;
using MyLibrary.Web.Data.Entities;
using MyLibrary.Web.DTOs;
using MyLibrary.Web.Services.Abstractions;

namespace MyLibrary.Web.Controllers
{
    public class BooksController : Controller
    {
        private readonly IBooksService _booksService;

        public BooksController(IBooksService BooksService)
        {
            _booksService = BooksService;
        }

        [HttpGet]
        public async Task<IActionResult> Index()
        {
            List<Book> list = await _booksService.GetListAsync();
            return View(list);
        }

        [HttpGet]
        public async Task<IActionResult> Create()
        {
            CreateBookDTO dto = new CreateBookDTO
            {
                Authors = await _booksService.GetAuthorsListAsync()
            };

            return View(dto);
        }

        [HttpPost]
        public async Task<IActionResult> Create(CreateBookDTO dto)
        {
            if (!ModelState.IsValid)
            {
                dto.Authors = await _booksService.GetAuthorsListAsync();
                return View(dto);
            }

            await _booksService.CreateAsync(dto);

            return RedirectToAction(nameof(Index));
        }

        [HttpGet]
        public async Task<IActionResult> GetOne([FromRoute] Guid id)
        {
            UpdateBookDTO dto = await _booksService.GetOneAsync(id);

            return View("Update", dto);
        }

        [HttpPost]
        public async Task<IActionResult> Update([FromForm] UpdateBookDTO dto)
        {
            if (!ModelState.IsValid)
            {
                dto.Authors = await _booksService.GetAuthorsListAsync();
                return View(dto);
            }

            await _booksService.UpdateAsync(dto);

            return RedirectToAction(nameof(Index));
        }

        [HttpPost]
        public async Task<IActionResult> Delete([FromRoute] Guid id)
        {
            await _booksService.DeleteAsync(id);

            return RedirectToAction(nameof(Index));
        }
    }
}
