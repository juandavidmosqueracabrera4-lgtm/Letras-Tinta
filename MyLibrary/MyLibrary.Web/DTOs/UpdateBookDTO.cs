using System.ComponentModel.DataAnnotations;
using Microsoft.AspNetCore.Mvc.Rendering;

namespace MyLibrary.Web.DTOs
{
    public class UpdateBookDTO
    {
        public Guid Id { get; set; }

        [MaxLength(128, ErrorMessage = "El campo {0} debe tener máximo {1} carácteres.")]
        [Required(ErrorMessage = "El campo {0} es requerido.")]
        public string Title { get; set; }

        [Required(ErrorMessage = "El campo {0} es requerido.")]
        public string Description { get; set; }

        public IEnumerable<SelectListItem>? Authors { get; set; }


        [Required(ErrorMessage = "El campo {0} es requerido.")]
        public Guid AuthorId { get; set; }
    }
}
