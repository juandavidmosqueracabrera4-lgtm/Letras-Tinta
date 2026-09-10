using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using MyLibrary.Web.Data;
using MyLibrary.Web.Data.Entities;
using MyLibrary.Web.DTOs;
using MyLibrary.Web.Services.Abstractions;

namespace MyLibrary.Web.Services.Implementations
{
    public class BooksService : IBooksService
    {
        private readonly DataContext _db;

        public BooksService(DataContext context)
        {
            _db = context;
        }

        public async Task<Book> CreateAsync(CreateBookDTO dto)
        {
            Book book = new Book
            {
                Id = Guid.NewGuid(),
                Description = dto.Description,
                Title = dto.Title,
                AuthorId = dto.AuthorId,
            };

            await _db.Books.AddAsync(book);
            await _db.SaveChangesAsync();

            return book;
        }

        public async Task DeleteAsync(Guid id)
        {
            Book? book = await _db.Books.FirstOrDefaultAsync(b => b.Id == id);

            if (book is null)
            {
                throw new Exception("El libro con id indicado no existe.");
            }

            _db.Books.Remove(book);

            await _db.SaveChangesAsync();
        }

        public async Task<List<Book>> GetListAsync()
        {
            return await _db.Books.Include(b => b.Author)
                                  .ToListAsync();
        }

        public async Task<UpdateBookDTO> GetOneAsync(Guid id)
        {
            Book? book = await _db.Books.FirstOrDefaultAsync(b => b.Id == id);

            if (book is null)
            {
                throw new Exception("El libro con id indicado no existe.");
            }

            return new UpdateBookDTO
            {
                Id = book.Id,
                AuthorId= book.AuthorId,
                Description = book.Description,
                Title = book.Title,
                Authors = await GetAuthorsListAsync(),
            };
        }

        public async Task<Book> UpdateAsync(UpdateBookDTO dto)
        {
            Book? book = await _db.Books.FirstOrDefaultAsync(b => b.Id == dto.Id);

            if (book is null)
            {
                throw new Exception("El libro con id indicado no existe.");
            }

            book.Title = dto.Title;
            book.AuthorId = dto.AuthorId;
            book.Description = dto.Description;

            _db.Books.Update(book);
            await _db.SaveChangesAsync();

            return book;
        }

        public async Task<IEnumerable<SelectListItem>> GetAuthorsListAsync()
        {
            return await _db.Authors.Select(a => new SelectListItem
            {
                Value = a.Id.ToString(),
                Text = $"{a.FirstName} {a.LastName}"
            }).ToListAsync();
        }
    }
}
