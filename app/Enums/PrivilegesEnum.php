<?php

namespace App\Enums;

enum PrivilegesEnum: string {

    case User        = 'User';
    case User_create = 'User create';
    case User_update = 'User update';
    case User_delete = 'User delete';

    case Role             = 'Role';
    case Role_create      = 'Role create';
    case Role_update      = 'Role update';
    case Role_delete      = 'Role delete';
    case Assign_privilege = 'Assign privilege';

    case Complaint               = 'Complaint';
    case Complaint_create        = 'Complaint create';
    case Complaint_show          = 'Complaint show';
    case Complaint_status_update = 'Complaint status update';

    case Category        = 'Category';
    case Category_create = 'Category create';
    case Category_show   = 'Category show';
    case Category_edit   = 'Category edit';
    case Category_delete = 'Category delete';

    case Comment_create = 'Comment create';

    case Reports                        = 'Reports';
    case Complaints_by_status_report    = 'Complaints by status report';
    case Complaints_by_priority_report  = 'Complaints by priority report';
    case Average_resolution_time_report = 'Average resolution time report';
    case Complaints_trend_report        = 'Complaints trend report';
}
