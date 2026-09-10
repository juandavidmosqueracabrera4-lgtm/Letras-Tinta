using System.ComponentModel.DataAnnotations;
using Microsoft.AspNetCore.Mvc.Rendering;

namespace MyLibrary.Web.DTOs
{
    public class CreateBookDTO
    {

        [MaxLength(128, ErrorMessage = "El campo {0} debe tener máximo {1} carácteres.")]
        [Required(ErrorMessage = "El campo {0} es requerido.")]
        [Display(Name = "Título")]
        public string Title { get; set; }

        [Required(ErrorMessage = "El campo {0} es requerido.")]
        [Display(Name = "Descripción")]
        public string Description { get; set; }

        public IEnumerable<SelectListItem>? Authors { get; set; }

        
        [Required(ErrorMessage = "El campo {0} es requerido.")]
        [Display(Name = "Autor")]
        public Guid AuthorId { get; set; }
    }
}
