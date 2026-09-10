using MyLibrary.Web.Data;
using MyLibrary.Web.Data.Entities;
using MyLibrary.Web.Services.Abstractions;
using Microsoft.EntityFrameworkCore;
using MyLibrary.Web.DTOs;

namespace MyLibrary.Web.Services.Implementations
{
    public class AuthorsService : IAuthorsService
    {
        private readonly DataContext _context;

        public AuthorsService(DataContext context)
        {
            _context = context;
        }

        public async Task<Author> CreateAsync(CreateAuthorDTO dto)
        {
            Author author = new Author
            {
                Id = Guid.CreateVersion7(),
                FirstName = dto.FirstName,
                LastName =  dto.LastName,
            };

            await _context.Authors.AddAsync(author);
            await _context.SaveChangesAsync();

            return author;
        }

        public async Task DeleteAsync(Guid id)
        {
            Author? author = await _context.Authors.FirstOrDefaultAsync(a => a.Id ==  id);

            if (author is null)
            {
                throw new Exception("No existe autor con el id indicado");
            }

            _context.Authors.Remove(author);
            await _context.SaveChangesAsync();
        }

        public async Task<List<Author>> GetListAsync()
        {
            List<Author> list = await _context.Authors.ToListAsync();

            return list;
        }

        public async Task<UpdateAuthorDTO> GetOneAsync(Guid id)
        {
            Author? author = await _context.Authors.FirstOrDefaultAsync(a => a.Id == id);

            if (author is null)
            {
                throw new Exception("No existe autor con el id indicado");
            }

            UpdateAuthorDTO dto = new UpdateAuthorDTO
            {
                Id = id,
                FirstName = author.FirstName,
                LastName= author.LastName,
            };

            return dto;
        }

        public async Task<Author> UpdateAsync(UpdateAuthorDTO dto)
        {
            Author? author = await _context.Authors.FirstOrDefaultAsync(a => a.Id == dto.Id);

            if (author is null)
            {
                throw new Exception("No existe autor con el id indicado");
            }

            author.FirstName = dto.FirstName;
            author.LastName = dto.LastName;

            _context.Authors.Update(author);
            await _context.SaveChangesAsync();

            return author;
        }
    }
}
