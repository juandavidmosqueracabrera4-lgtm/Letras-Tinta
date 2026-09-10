using Microsoft.AspNetCore.Mvc.Rendering;
using MyLibrary.Web.Data.Entities;
using MyLibrary.Web.DTOs;

namespace MyLibrary.Web.Services.Abstractions
{
    public interface IBooksService
    {
        public Task<List<Book>> GetListAsync();
        public Task<Book> CreateAsync(CreateBookDTO dto);
        public Task<Book> UpdateAsync(UpdateBookDTO dto);
        public Task DeleteAsync(Guid id);
        public Task<UpdateBookDTO> GetOneAsync(Guid id);
        public Task<IEnumerable<SelectListItem>> GetAuthorsListAsync();
    }
}
