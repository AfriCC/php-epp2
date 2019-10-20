<?php

namespace AfriCC\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\Report;

class GetData extends Report
{
    /**
     * Set ReportID to retrieve data from.
     *
     * @param string $reportId
     */
    public function setReportId($reportId)
    {
        $this->set('extreport:getData/extreport:extreportId', $reportId);
    }
}
