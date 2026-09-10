using MyLibrary.Web.Data.Entities;
using MyLibrary.Web.DTOs;

namespace MyLibrary.Web.Services.Abstractions
{
    public interface IAuthorsService
    {
        public Task<List<Author>> GetListAsync();
        public Task<Author> CreateAsync(CreateAuthorDTO dto);
        public Task<Author> UpdateAsync(UpdateAuthorDTO dto);
        public Task DeleteAsync(Guid id);
        public Task<UpdateAuthorDTO> GetOneAsync(Guid id);
    }
}
