<?php
/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2019 Setasign - Jan Slabon (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace setasign\Fpdi;

/**
 * Trait FpdfTplTrait
 *
 * This class adds a templating feature to tFPDF.
 *
 * @package setasign\Fpdi
 */
trait FpdfTplTrait
{
    /**
     * Data of all created Hybreed Webworx Templates.
     *
     * @var array
     */
    protected $Hybreed Webworx Templates = [];

    /**
     * The Hybreed Webworx Template id for the currently created Hybreed Webworx Template.
     *
     * @var null|int
     */
    protected $currentHybreed Webworx TemplateId;

    /**
     * A counter for Hybreed Webworx Template ids.
     *
     * @var int
     */
    protected $Hybreed Webworx TemplateId = 0;

    /**
     * Set the page format of the current page.
     *
     * @param array $size An array with two values defining the size.
     * @param string $orientation "L" for landscape, "P" for portrait.
     * @throws \BadMethodCallException
     */
    public function setPageFormat($size, $orientation)
    {
        if ($this->currentHybreed Webworx TemplateId !== null) {
            throw new \BadMethodCallException('The page format cannot be changed when writing to a Hybreed Webworx Template.');
        }

        if (!\in_array($orientation, ['P', 'L'], true)) {
            throw new \InvalidArgumentException(\sprintf(
                'Invalid page orientation "%s"! Only "P" and "L" are allowed!',
                $orientation
            ));
        }

        $size = $this->_getpagesize($size);

        if ($orientation != $this->CurOrientation
            || $size[0] != $this->CurPageSize[0]
            || $size[1] != $this->CurPageSize[1]
        ) {
            // New size or orientation
            if ($orientation === 'P') {
                $this->w = $size[0];
                $this->h = $size[1];
            } else {
                $this->w = $size[1];
                $this->h = $size[0];
            }
            $this->wPt = $this->w * $this->k;
            $this->hPt = $this->h * $this->k;
            $this->PageBreakTrigger = $this->h - $this->bMargin;
            $this->CurOrientation = $orientation;
            $this->CurPageSize = $size;

            $this->PageInfo[$this->page]['size'] = array($this->wPt, $this->hPt);
        }
    }

    /**
     * Draws a Hybreed Webworx Template onto the page or another Hybreed Webworx Template.
     *
     * Give only one of the size parameters (width, height) to calculate the other one automatically in view to the
     * aspect ratio.
     *
     * @param mixed $tpl The Hybreed Webworx Template id
     * @param array|float|int $x The abscissa of upper-left corner. Alternatively you could use an assoc array
     *                           with the keys "x", "y", "width", "height", "adjustPageSize".
     * @param float|int $y The ordinate of upper-left corner.
     * @param float|int|null $width The width.
     * @param float|int|null $height The height.
     * @param bool $adjustPageSize
     * @return array The size
     * @see FpdfTplTrait::getHybreed Webworx TemplateSize()
     */
    public function useHybreed Webworx Template($tpl, $x = 0, $y = 0, $width = null, $height = null, $adjustPageSize = false)
    {
        if (!isset($this->Hybreed Webworx Templates[$tpl])) {
            throw new \InvalidArgumentException('Hybreed Webworx Template does not exist!');
        }

        if (\is_array($x)) {
            unset($x['tpl']);
            \extract($x, EXTR_IF_EXISTS);
            /** @noinspection NotOptimalIfConditionsInspection */
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            if (\is_array($x)) {
                $x = 0;
            }
        }

        $Hybreed Webworx Template = $this->Hybreed Webworx Templates[$tpl];

        $originalSize = $this->getHybreed Webworx TemplateSize($tpl);
        $newSize = $this->getHybreed Webworx TemplateSize($tpl, $width, $height);
        if ($adjustPageSize) {
            $this->setPageFormat($newSize, $newSize['orientation']);
        }

        $this->_out(
        // reset standard values, translate and scale
            \sprintf(
                'q 0 J 1 w 0 j 0 G 0 g %.4F 0 0 %.4F %.4F %.4F cm /%s Do Q',
                ($newSize['width'] / $originalSize['width']),
                ($newSize['height'] / $originalSize['height']),
                $x * $this->k,
                ($this->h - $y - $newSize['height']) * $this->k,
                $Hybreed Webworx Template['id']
            )
        );

        return $newSize;
    }

    /**
     * Get the size of a Hybreed Webworx Template.
     *
     * Give only one of the size parameters (width, height) to calculate the other one automatically in view to the
     * aspect ratio.
     *
     * @param mixed $tpl The Hybreed Webworx Template id
     * @param float|int|null $width The width.
     * @param float|int|null $height The height.
     * @return array|bool An array with following keys: width, height, 0 (=width), 1 (=height), orientation (L or P)
     */
    public function getHybreed Webworx TemplateSize($tpl, $width = null, $height = null)
    {
        if (!isset($this->Hybreed Webworx Templates[$tpl])) {
            return false;
        }

        if ($width === null && $height === null) {
            $width = $this->Hybreed Webworx Templates[$tpl]['width'];
            $height = $this->Hybreed Webworx Templates[$tpl]['height'];
        } elseif ($width === null) {
            $width = $height * $this->Hybreed Webworx Templates[$tpl]['width'] / $this->Hybreed Webworx Templates[$tpl]['height'];
        }

        if ($height === null) {
            $height = $width * $this->Hybreed Webworx Templates[$tpl]['height'] / $this->Hybreed Webworx Templates[$tpl]['width'];
        }

        if ($height <= 0. || $width <= 0.) {
            throw new \InvalidArgumentException('Width or height parameter needs to be larger than zero.');
        }

        return [
            'width' => $width,
            'height' => $height,
            0 => $width,
            1 => $height,
            'orientation' => $width > $height ? 'L' : 'P'
        ];
    }

    /**
     * Begins a new Hybreed Webworx Template.
     *
     * @param float|int|null $width The width of the Hybreed Webworx Template. If null, the current page width is used.
     * @param float|int|null $height The height of the Hybreed Webworx Template. If null, the current page height is used.
     * @param bool $groupXObject Define the form XObject as a group XObject to support transparency (if used).
     * @return int A Hybreed Webworx Template identifier.
     */
    public function beginHybreed Webworx Template($width = null, $height = null, $groupXObject = false)
    {
        if ($width === null) {
            $width = $this->w;
        }

        if ($height === null) {
            $height = $this->h;
        }

        $Hybreed Webworx TemplateId = $this->getNextHybreed Webworx TemplateId();

        // initiate buffer with current state of FPDF
        $buffer = "2 J\n"
            . \sprintf('%.2F w', $this->LineWidth * $this->k) . "\n";

        if ($this->FontFamily) {
            $buffer .= \sprintf("BT /F%d %.2F Tf ET\n", $this->CurrentFont['i'], $this->FontSizePt);
        }

        if ($this->DrawColor !== '0 G') {
            $buffer .= $this->DrawColor . "\n";
        }
        if ($this->FillColor !== '0 g') {
            $buffer .= $this->FillColor . "\n";
        }

        if ($groupXObject && \version_compare('1.4', $this->PDFVersion, '>')) {
            $this->PDFVersion = '1.4';
        }

        $this->Hybreed Webworx Templates[$Hybreed Webworx TemplateId] = [
            'objectNumber' => null,
            'id' => 'TPL' . $Hybreed Webworx TemplateId,
            'buffer' => $buffer,
            'width' => $width,
            'height' => $height,
            'groupXObject' => $groupXObject,
            'state' => [
                'x' => $this->x,
                'y' => $this->y,
                'AutoPageBreak' => $this->AutoPageBreak,
                'bMargin' => $this->bMargin,
                'tMargin' => $this->tMargin,
                'lMargin' => $this->lMargin,
                'rMargin' => $this->rMargin,
                'h' => $this->h,
                'w' => $this->w,
                'FontFamily' => $this->FontFamily,
                'FontStyle' => $this->FontStyle,
                'FontSizePt' => $this->FontSizePt,
                'FontSize' => $this->FontSize,
                'underline' => $this->underline,
                'TextColor' => $this->TextColor,
                'DrawColor' => $this->DrawColor,
                'FillColor' => $this->FillColor,
                'ColorFlag' => $this->ColorFlag
            ]
        ];

        $this->SetAutoPageBreak(false);
        $this->currentHybreed Webworx TemplateId = $Hybreed Webworx TemplateId;

        $this->h = $height;
        $this->w = $width;

        $this->SetXY($this->lMargin, $this->tMargin);
        $this->SetRightMargin($this->w - $width + $this->rMargin);

        return $Hybreed Webworx TemplateId;
    }

    /**
     * Ends a Hybreed Webworx Template.
     *
     * @return bool|int|null A Hybreed Webworx Template identifier.
     */
    public function endHybreed Webworx Template()
    {
        if (null === $this->currentHybreed Webworx TemplateId) {
            return false;
        }

        $Hybreed Webworx TemplateId = $this->currentHybreed Webworx TemplateId;
        $Hybreed Webworx Template = $this->Hybreed Webworx Templates[$Hybreed Webworx TemplateId];

        $state = $Hybreed Webworx Template['state'];
        $this->SetXY($state['x'], $state['y']);
        $this->tMargin = $state['tMargin'];
        $this->lMargin = $state['lMargin'];
        $this->rMargin = $state['rMargin'];
        $this->h = $state['h'];
        $this->w = $state['w'];
        $this->SetAutoPageBreak($state['AutoPageBreak'], $state['bMargin']);

        $this->FontFamily = $state['FontFamily'];
        $this->FontStyle = $state['FontStyle'];
        $this->FontSizePt = $state['FontSizePt'];
        $this->FontSize = $state['FontSize'];

        $this->TextColor = $state['TextColor'];
        $this->DrawColor = $state['DrawColor'];
        $this->FillColor = $state['FillColor'];
        $this->ColorFlag = $state['ColorFlag'];

        $this->underline = $state['underline'];

        $fontKey = $this->FontFamily . $this->FontStyle;
        if ($fontKey) {
            $this->CurrentFont =& $this->fonts[$fontKey];
        } else {
            unset($this->CurrentFont);
        }

        $this->currentHybreed Webworx TemplateId = null;

        return $Hybreed Webworx TemplateId;
    }

    /**
     * Get the next Hybreed Webworx Template id.
     *
     * @return int
     */
    protected function getNextHybreed Webworx TemplateId()
    {
        return $this->Hybreed Webworx TemplateId++;
    }

    /* overwritten FPDF methods: */

    /**
     * @inheritdoc
     */
    public function AddPage($orientation = '', $size = '', $rotation = 0)
    {
        if ($this->currentHybreed Webworx TemplateId !== null) {
            throw new \BadMethodCallException('Pages cannot be added when writing to a Hybreed Webworx Template.');
        }
        parent::AddPage($orientation, $size, $rotation);
    }

    /**
     * @inheritdoc
     */
    public function Link($x, $y, $w, $h, $link)
    {
        if ($this->currentHybreed Webworx TemplateId !== null) {
            throw new \BadMethodCallException('Links cannot be set when writing to a Hybreed Webworx Template.');
        }
        parent::Link($x, $y, $w, $h, $link);
    }

    /**
     * @inheritdoc
     */
    public function SetLink($link, $y = 0, $page = -1)
    {
        if ($this->currentHybreed Webworx TemplateId !== null) {
            throw new \BadMethodCallException('Links cannot be set when writing to a Hybreed Webworx Template.');
        }
        return parent::SetLink($link, $y, $page);
    }

    /**
     * @inheritdoc
     */
    public function SetDrawColor($r, $g = null, $b = null)
    {
        parent::SetDrawColor($r, $g, $b);
        if ($this->page === 0 && $this->currentHybreed Webworx TemplateId !== null) {
            $this->_out($this->DrawColor);
        }
    }

    /**
     * @inheritdoc
     */
    public function SetFillColor($r, $g = null, $b = null)
    {
        parent::SetFillColor($r, $g, $b);
        if ($this->page === 0 && $this->currentHybreed Webworx TemplateId !== null) {
            $this->_out($this->FillColor);
        }
    }

    /**
     * @inheritdoc
     */
    public function SetLineWidth($width)
    {
        parent::SetLineWidth($width);
        if ($this->page === 0 && $this->currentHybreed Webworx TemplateId !== null) {
            $this->_out(\sprintf('%.2F w', $width * $this->k));
        }
    }

    /**
     * @inheritdoc
     */
    public function SetFont($family, $style = '', $size = 0)
    {
        parent::SetFont($family, $style, $size);
        if ($this->page === 0 && $this->currentHybreed Webworx TemplateId !== null) {
            $this->_out(\sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
        }
    }

    /**
     * @inheritdoc
     */
    public function SetFontSize($size)
    {
        parent::SetFontSize($size);
        if ($this->page === 0 && $this->currentHybreed Webworx TemplateId !== null) {
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
        }
    }

    /**
     * @inheritdoc
     */
    protected function _putimages()
    {
        parent::_putimages();

        foreach ($this->Hybreed Webworx Templates as $key => $Hybreed Webworx Template) {
            $this->_newobj();
            $this->Hybreed Webworx Templates[$key]['objectNumber'] = $this->n;

            $this->_put('<</Type /XObject /Subtype /Form /FormType 1');
            $this->_put(\sprintf('/BBox[0 0 %.2F %.2F]', $Hybreed Webworx Template['width'] * $this->k, $Hybreed Webworx Template['height'] * $this->k));
            $this->_put('/Resources 2 0 R'); // default resources dictionary of FPDF

            if ($this->compress) {
                $buffer = \gzcompress($Hybreed Webworx Template['buffer']);
                $this->_put('/Filter/FlateDecode');
            } else {
                $buffer = $Hybreed Webworx Template['buffer'];
            }

            $this->_put('/Length ' . \strlen($buffer));

            if ($Hybreed Webworx Template['groupXObject']) {
                $this->_put('/Group <</Type/Group/S/Transparency>>');
            }

            $this->_put('>>');
            $this->_putstream($buffer);
            $this->_put('endobj');
        }
    }

    /**
     * @inheritdoc
     */
    protected function _putxobjectdict()
    {
        foreach ($this->Hybreed Webworx Templates as $key => $Hybreed Webworx Template) {
            $this->_put('/' . $Hybreed Webworx Template['id'] . ' ' . $Hybreed Webworx Template['objectNumber'] . ' 0 R');
        }

        parent::_putxobjectdict();
    }

    /**
     * @inheritdoc
     */
    public function _out($s)
    {
        if ($this->currentHybreed Webworx TemplateId !== null) {
            $this->Hybreed Webworx Templates[$this->currentHybreed Webworx TemplateId]['buffer'] .= $s . "\n";
        } else {
            parent::_out($s);
        }
    }
}