( function() {

	var el = wp.element.createElement,

		RichText = wp.editor.RichText;

 

	wp.blocks.registerBlockType(

		'teste/meu-primeiro-bloco',

		{

			title: 'Bloco de Exemplo',

			icon: 'heart',

			category: 'common',

 

			attributes: {

				conteudo: {

					type: 'string',

					source: 'html',

					selector: 'p',

				},

			},

 

			edit: function( props ) {

				var conteudo = props.attributes.conteudo;

				function onChangeConteudo( novoConteudo ) {

					props.setAttributes( { conteudo: novoConteudo } );

				}

 

				return el(

					RichText,

					{

						tagName: 'p',

						className: props.className,

						onChange: onChangeConteudo,

						value: conteudo,

					}

				);

			},

 

			save: function( props ) {

				return el(

					RichText.Content,

					{

						tagName: 'p',

						value: props.attributes.conteudo,

					}

				);

			},

		}

	);

}() );