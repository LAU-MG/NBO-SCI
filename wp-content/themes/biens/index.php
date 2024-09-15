<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biens Immobiliers</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="site-logo mb-4 text-center">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="text-decoration-none">
                <h1><?php bloginfo('name'); ?></h1>
            </a>
        </div>

        <?php
        $args = array(
            'post_type'      => 'bien_immobilier',
            'posts_per_page' => -1,
        );

        $biens_query = new WP_Query($args);

        if ($biens_query->have_posts()) :
            echo '<p class="text-success">Des biens immobiliers ont été trouvés.</p>';
            while ($biens_query->have_posts()) :
                $biens_query->the_post();
                $post_id = get_the_ID();
                ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $post_id; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $post_id; ?>">
                                <?php the_title(); ?>
                            </button>
                            <button class="btn btn-primary generate-pdf" data-postid="<?php echo $post_id; ?>">Générer PDF</button>
                        </h2>
                    </div>

                    <div id="collapse-<?php echo $post_id; ?>" class="collapse" aria-labelledby="heading-<?php echo $post_id; ?>" data-parent=".container">
                        <div class="card-body">
                            <?php
                            // Récupération des métadonnées avec Carbon Fields
                            $adresse = carbon_get_the_post_meta('adresse_texte');
                            $codepostal = carbon_get_the_post_meta('codepostal');
                            $ville = carbon_get_the_post_meta('ville');
                            $annee = carbon_get_the_post_meta('annee');
                            $piece = carbon_get_the_post_meta('piece');
                            $metre = carbon_get_the_post_meta('metre');
                            $etage = carbon_get_the_post_meta('etage');
                            $cave = carbon_get_the_post_meta('cave');
                            $ascenseur = carbon_get_the_post_meta('ascenseur');
                            $parking = carbon_get_the_post_meta('parking');
                            $terrasse = carbon_get_the_post_meta('terrasse');
                            $patio = carbon_get_the_post_meta('patio');
                            $jardin = carbon_get_the_post_meta('jardin');
                            $chauffage = carbon_get_the_post_meta('chauffage');
                            $quotepart = carbon_get_the_post_meta('quotepart');
                            $procedure = carbon_get_the_post_meta('procedure');

                            echo '<p><strong>Adresse :</strong> ' . esc_html($adresse) . '</p>';
                            echo '<p><strong>Code Postal :</strong> ' . esc_html($codepostal) . '</p>';
                            echo '<p><strong>Ville :</strong> ' . esc_html($ville) . '</p>';
                            echo '<p><strong>Année de construction :</strong> ' . esc_html($annee) . '</p>';
                            echo '<p><strong>Nombre de pièces :</strong> ' . esc_html($piece) . '</p>';
                            echo '<p><strong>Surface :</strong> ' . esc_html($metre) . ' m²</p>';
                            echo '<p><strong>Étage :</strong> ' . esc_html($etage) . '</p>';
                            echo '<p><strong>Cave :</strong> ' . ($cave ? 'Oui' : 'Non') . '</p>';
                            echo '<p><strong>Ascenseur :</strong> ' . ($ascenseur ? 'Oui' : 'Non') . '</p>';
                            echo '<p><strong>Parking / Garage :</strong> ' . ($parking ? 'Oui' : 'Non') . '</p>';
                            echo '<p><strong>Terrasse :</strong> ' . ($terrasse ? 'Oui' : 'Non') . '</p>';
                            echo '<p><strong>Patio :</strong> ' . ($patio ? 'Oui' : 'Non') . '</p>';
                            echo '<p><strong>Jardin :</strong> ' . ($jardin ? 'Oui' : 'Non') . '</p>';
                            if (is_array($chauffage)) {
                                echo '<p><strong>Type(s) de chauffage :</strong> ' . implode(', ', array_map('esc_html', $chauffage)) . '</p>';
                            }
                            echo '<p><strong>Quotepart :</strong> ' . esc_html($quotepart) . '</p>';
                            echo '<p><strong>Procédure :</strong> ' . ($procedure ? 'Oui' : 'Non') . '</p>';

                            // Affichage des images du bien
                            $images = carbon_get_the_post_meta('images_bien');
                            if ($images) {
                                echo '<div class="row">';
                                foreach ($images as $image) {
                                    echo '<div class="col-md-4 mb-3">';
                                    echo wp_get_attachment_image($image['image'], 'medium', false, array('class' => 'img-fluid'));
                                    echo '</div>';
                                }
                                echo '</div>';
                            }
                            ?>
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p class="text-danger">Aucun bien immobilier trouvé.</p>';
        endif;
        ?>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
        <script>
            jQuery(document).ready(function($) {
                // Activer l'accordéon Bootstrap
                $('.collapse').collapse();

                $(".generate-pdf").on("click", function(event) {
                    event.preventDefault();

                    console.log("Bouton cliqué"); // Débogage : Vérifier si le bouton est cliqué

                    var post_id = $(this).data('postid');
                    var accordionId = '#collapse-' + post_id;

                    console.log("Post ID: " + post_id); // Débogage : Vérifier le post_id

                    // Assurez-vous que l'accordéon est complètement ouvert avant de capturer
                    $(accordionId).collapse('show');

                    // Attendez que l'animation de l'accordéon soit terminée
                    $(accordionId).on('shown.bs.collapse', function () {
                        console.log("Accordéon ouvert"); // Débogage : Vérifier si l'accordéon est ouvert

                        html2canvas($(accordionId)[0]).then(function(canvas) {
                            var imgData = canvas.toDataURL('image/png');
                            var imgWidth = 210; // Largeur de l'image en mm (A4 à 72 dpi)
                            var pageHeight = 297; // Hauteur de la page en mm (A4 à 72 dpi)
                            var imgHeight = canvas.height * imgWidth / canvas.width;
                            var heightLeft = imgHeight;
                            var position = 0;

                            console.log("Image capturée"); // Débogage : Vérifier si l'image est capturée

                            var pdf = new jspdf.jsPDF('p', 'mm', 'a4'); // Nouveau document PDF au format A4
                            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                            heightLeft -= pageHeight;

                            // Ajouter les pages supplémentaires si nécessaire
                            while (heightLeft >= 0) {
                                position = heightLeft - imgHeight;
                                pdf.addPage();
                                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                                heightLeft -= pageHeight;
                            }

                            console.log("PDF généré"); // Débogage : Vérifier si le PDF est généré

                            // Télécharger le PDF
                            pdf.save('bien_immobilier_' + post_id + '.pdf');
                            console.log("PDF téléchargé"); // Débogage : Vérifier si le PDF est téléchargé
                        }).catch(function(error) {
                            console.error("Erreur html2canvas: ", error); // Débogage : Afficher les erreurs html2canvas
                        });
                    }).on('hidden.bs.collapse', function () {
                        console.log("Accordéon fermé"); // Débogage : Vérifier si l'accordéon est fermé
                    });
                });
            });
        </script>
    </div>
</body>
</html>