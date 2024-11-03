<?php
namespace App\Http\Services;

use App\Enums\StatusTypeEnum;
use App\Repositories\Comment\ICommentRepository;
use App\Repositories\ComplaintAttachment\IComplaintAttachmentRepository;
use App\Repositories\ComplaintStatusHistory\IComplaintStatusHistoryRepository;
use App\Repositories\Complaint\IComplaintRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComplaintService
{
    public function __construct(private IComplaintRepository $complaintRepository, private IComplaintStatusHistoryRepository $complaintStatusHistoryRepository, private ICommentRepository $commentRepository)
    {

    }

    /**
     * Create complaint
     *
     * @param  array $data
     * @return array|null
     */
    public function createComplaint(array $data): ?array
    {
        try {
            DB::beginTransaction();
    
            // Initialize $attachmentPath as null if no file is uploaded
            $attachmentPath = null;
    
            if (request()->hasFile('attachment') && request()->file('attachment')->isValid()) {
                // Handle the file upload
                $attachment = request()->file('attachment');
                $directory = 'uploads/' . now()->format('Y/m/d');
                $fileName = Str::random(20) . '_' . $attachment->getClientOriginalName();
                $path = $attachment->storeAs('public/' . $directory, $fileName);
    
                $attachmentPath = $directory . '/' . $fileName;
            }
    
            // Create the complaint record
            $complaint = $this->complaintRepository->create([
                'user_id' => Auth::id(),
                'title' => data_get($data, 'title'),
                'description' => data_get($data, 'description'),
                'category_id' => data_get($data, 'category_id'),
                'priority' => data_get($data, 'priority'),
                'created_by' => Auth::id(),
                'attachment' => $attachmentPath, // Will be null if no file uploaded
                'submitted_at' => now(),
            ]);
    
            DB::commit();
            return $complaint->toArray();
    
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * update Complaint Status
     *
     * @param  array $data
     * @param  int $complaintId
     * @return array|null
     */
    public function updateComplaintStatus(array $data, int $complaintId): ?array
    {

        $complaint         = $this->complaintRepository->find($complaintId);
        $complaint->status = data_get($data, 'status');
        if ($complaint->status == StatusTypeEnum::Resolved->value) {
            $complaint->resolved_at = now();
        }
        $complaint->save();

        // Log the status change in ComplaintStatusHistory
        $this->complaintStatusHistoryRepository->create([
            'complaint_id' => $complaint->id,
            'status'       => data_get($data, 'status'),
            'changed_at'   => now(),
        ]);

        return $complaint->toArray();

    }

    /**
     * create comment
     *
     * @param  array $data
     * @param  int $complaintId
     * @return array|null
     */
    public function createComment(array $data, int $complaintId): ?array
    {
        $comment = $this->commentRepository->create([
            'complaint_id' => $complaintId,
            'admin_id'     => Auth::id(),
            'comment'      => data_get($data, 'comment'),
        ]);

        return $comment->toArray();

    }

}
